<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionStatus;

class ReAccrual
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        Gate::allowIf(fn ($user) => !$user->isAdministrator());

        $user = $this::authenticatedUser();

        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'reaccruals')->first();
        if ( $roleId == null || $menu == null ) {
            return false;
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return false;
        }
        $permission = $roleMenu->is_create;

        if ( $permission == PermissionStatus::NOTALLOWED ) {
            return false;
        }

        $reAccrualAlreadyExists = $user->expenses()
            ->where('period_id', $user->activePeriod()?->id)
            ->where('reversal_of_expense_id', $args['id'])
            ->exists();

        if ($reAccrualAlreadyExists) {
            return false;
        }

        $previousPeriod = $user->activePeriod()?->previous();

        $expense = $user->expenses()
            ->where('id', $args['id'])
            ->where('period_id', $previousPeriod?->id)
            ->whereHas('expenseType', function (Builder $query) {
                $query->where('type', 'Accrual')
                    ->orWhere('type', 'ReAccrual');
            })
            ->firstOrFail();

        $expenseData = Arr::only(
            $expense->toArray(), 
            ['gl_account_id', 'expense_date', 'amount', 'comments', 'vendor_id', 'user_id']
        );

        Expense::create(array_merge($expenseData, [
            'expense_type_id' => ExpenseType::expenseType('ReAccrual')?->id,
            'reversal_of_expense_id' => $expense->id
        ]));
        Expense::create(array_merge($expenseData, [
            'expense_type_id' => ExpenseType::expenseType('Reversal')?->id,
            'reversal_of_expense_id' => $expense->id
        ]));
        
        return true;
    }
    
}