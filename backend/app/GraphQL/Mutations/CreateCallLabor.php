<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Traits\Auth\ManagesAuth;
use App\Models\Period;
use App\Models\ExpenseType;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Enums\PermissionStatus;

class CreateCallLabor
{
    use ManagesAuth;
    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Gate::allowIf(fn ($user) => !$user->isAdministrator() && $user->hasSelectedUnit());

        // permission check
        $user = static::authenticatedUser();
        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'on-call-labor')->first();
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
            // get current time as Date ex: xxxx-xx-xx format
            $nowTime = Carbon::now();
            $nowDate = $nowTime->toDateString();

            // get the expense_type for OnCall expense
            $callLaborExpenseType = DB::table('expense_types')->where('type', 'OnCall')->first();

            // get the current period
            $currentPeriod = Period::currentPeriod();

            // insert the OnCall expense record to the expenses table
            $newExpense = new Expense();
            $newExpense->expense_type_id = $callLaborExpenseType->id;
            // $newExpense->gl_account_id = $expense->gl_account_id; // not supported
            $newExpense->expense_date = $nowDate; // not null
            $newExpense->amount = $args['amount']; // not null
            $newExpense->comments = $args['comments']; // not null
            // $newExpense->vendor_id = $expense->id; // not supported
            $newExpense->unit_id = $selectedUnit?->id;
            $newExpense->period_id = $currentPeriod->id;
            $newExpense->user_id = $user->id;
            // $newExpense->reversal_of_expense_id = $expense->id; // not supported
            
            $newExpense->save();
            DB::commit();

            // return $newExpense; // return response
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => false,
                'message' => __('create_callLabor.error')
            ];
        }
        
        return [
            'status' => true,
            'message' => __('create_callLabor.created')
        ];
    }
}