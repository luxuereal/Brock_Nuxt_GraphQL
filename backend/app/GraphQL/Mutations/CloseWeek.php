<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\ExpenseType;
use App\Models\Expense;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Enums\PermissionStatus;

class CloseWeek
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        Gate::allowIf(fn ($user) => !$user->isAdministrator() && $user->hasSelectedUnit());

        $user = static::authenticatedUser();
        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'close-week')->first();
        if ( $roleId == null || $menu == null ) {
            return [
                'status' => false,
                'message' => 'Unknown Slug Name'
            ];
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return [
                'status' => false,
                'message' => 'Unknown Permission'
            ];
        }
        $permission = $roleMenu->is_create;

        if ( $permission == PermissionStatus::NOTALLOWED ) {
            return [
                'status' => false,
                'message' => 'You must have a create permission'
            ];
        }

        DB::beginTransaction();

        try {
            $user = static::authenticatedUser();
            
            $selectedUnit = $user->selectedUnit();
            $activePeriod = $selectedUnit->activePeriod();
            $previousPeriod = $activePeriod?->previous();

            // get the records from fixed_expenses table where the date is current active Period and monthly is false

            // check if it's the first week
            if ( $activePeriod?->week == 1 ) {
                $fixedExpenses = DB::table('fixed_expenses')->where('unit_id', $selectedUnit->id)->get();
            } else {
                $fixedExpenses = DB::table('fixed_expenses')->where('unit_id', $selectedUnit->id)->where('monthly', false)->get();
            }
            /*
            When the location manager is closing a week all records from the "fixed_expenses" table must be pre-populated to expenses. This functionality is because sometimes they have "fixed expenses" that occur each week, so they have a different table and at the end, records are copied each week to expenses.

            
            1. I checked that, and it looks like you missed one thing. unit_id. I closed a week on unit 4, and it added three expenses for me: one was from unit id 2 and two from 14. It must add only my unit data
            2. This list shows all fixed expenses instead of only my unit items (unit 4 doesn't have any fixed expenses. )
            image.png

            image (1).png
            3. setup expense_date as the current time

             */
            // unit_id, monthly, gl_account_id, amount, comments, created_at, updated_at

            // get the expense_type for Fixed expense
            $fixedExpenseType = DB::table('expense_types')->where('type', 'Fixed')->first();

            // pre-populate the fixed_expenses to expenses table
            $nowTime = Carbon::now();
            $nowDate = $nowTime->toDateString();
            foreach($fixedExpenses as $expense) {
                $newExpense = new Expense();
                $newExpense->expense_type_id = $fixedExpenseType->id;
                $newExpense->gl_account_id = $expense->gl_account_id;
                $newExpense->expense_date = $nowDate; // not null
                $newExpense->amount = $expense->amount; // not null
                $newExpense->comments = $expense->comments; // not null
                // $newExpense->vendor_id = $expense->id; // not supported
                $newExpense->unit_id = $expense->unit_id;
                $newExpense->period_id = $activePeriod?->id;
                $newExpense->user_id = $user->id;
                // $newExpense->reversal_of_expense_id = $expense->id; // not supported
                $newExpense->save();
            }

            // reversals
            if ($previousPeriodId = $previousPeriod?->id) {
                $expenses = $user->expenses()
                    ->whereHas('expenseType', function(Builder $query) {
                        $query->where('type', '=' ,'Accrual')
                            ->orWhere('type', '=', 'ReAccrual');
                    })
                    ->orWhere('period_id', $activePeriod?->id)
                    ->get()
                    ->groupBy('period_id');

                if (Arr::exists($expenses, $previousPeriodId)) {
                    foreach ($expenses[$previousPeriodId] as $previousExpense) {
                        $currentExpense = null;

                        if (isset($expenses[$activePeriod?->id])) {
                            $currentExpense = $expenses[$activePeriod?->id]
                                ->where('reversal_of_expense_id', $previousExpense->id)->toArray();
                        }

                        if (empty($currentExpense)) {
                            $reversal = $previousExpense->replicate()->fill([
                                'expense_type_id' => ExpenseType::expenseType('Reversal')?->id,
                                'reversal_of_expense_id' => $previousExpense->id
                            ]);

                            $reversal->save();
                        }
                    }
                }
            }
            
            if (!is_null($activePeriod)) {
                $selectedUnit->periods()->updateExistingPivot($activePeriod->id, [
                    'is_closed' => true
                ]);
                
                $next = $activePeriod->next();
                
                $selectedUnit->periods()->attach($next);
                
                DB::commit();
            } else {
                DB:: rollback();
            }
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => false,
                'message' => 'failed'
            ];
        }
        
        return [
            'status' => true,
            'message' => 'success'
        ];
    }
}