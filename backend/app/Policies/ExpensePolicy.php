<?php

namespace App\Policies;

use App\Models\Expense;
use App\Models\User;
use App\Models\RoleMenu;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Exceptions\ClientException;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionStatus;

class ExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if (!$user->isAdministrator()) {
            if (!$user->hasSelectedUnit()) {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // permission check
        if ($user->isAdministrator()) {
            return true;
        }
        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'expenses')->first();
        if ( $roleId == null || $menu == null ) {
            return false;
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return false;
        }
        $permission = $roleMenu->is_view;
        if ( $permission == PermissionStatus::ALLOWED ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Expense $expense)
    {
        // permission check
        if ($user->isAdministrator()) {
            return true;
        }
        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'expenses')->first();
        if ( $roleId == null || $menu == null ) {
            return false;
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return false;
        }
        $permission = $roleMenu->is_view;
        if ( $permission == PermissionStatus::ALLOWED ) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  array  $injectedArgs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, array $injectedArgs)
    {   
        if ($user->isAdministrator()) {
            return true;
        } else {
            // permission check
            $roleId = $user->role_id;

            $expenseType = DB::table('expense_types')->where('id', '=', $injectedArgs['expenseType'])->first();
            if($expenseType == null) {
                return false;
            }

            if($expenseType->type == 'ReAccural') {
                $menu = DB::table('menus')->where('slug_name', '=', 'reaccruals')->first();
            } else {
                $menu = DB::table('menus')->where('slug_name', '=', 'expenses')->first();
            }

            if ( $roleId == null || $menu == null ) {
                return false;
            }

            $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
            if ( $roleMenu == null ) {
                return false;
            }
            $permission = $roleMenu->is_create;
            if ( $permission == PermissionStatus::ALLOWED ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @param  array  $injectedArgs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Expense $expense, array $injectedArgs)
    {
        if ($user->isAdministrator()) {
            return true;
        }
        if ($user->activePeriod()?->id === $expense->period_id &&
            $user->id === $expense->user_id &&
            !$user->isAdministrator()) {
            
            // permission check
            $roleId = $user->role_id;

            $expenseType = DB::table('expense_types')->where('id', '=', $injectedArgs['expenseType'])->first();
            if($expenseType == null) {
                return false;
            }
            if($expenseType->type == 'ReAccural') {
                $menu = DB::table('menus')->where('slug_name', '=', 'reaccruals')->first();
            } else {
                $menu = DB::table('menus')->where('slug_name', '=', 'expenses')->first();
            }
            if ( $roleId == null || $menu == null ) {
                return false;
            }
            $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
            if ( $roleMenu == null ) {
                return false;
            }
            $permission = $roleMenu->is_modify;
            if ( $permission == PermissionStatus::ALLOWED ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @param  array  $injectedArgs
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Expense $expense, array $injectedArgs)
    {
        if ($user->isAdministrator()) {
            return true;
        }
        if ($user->activePeriod()?->id === $expense->period_id &&
            $user->id === $expense->user_id &&
            !$user->isAdministrator()) {
            
            // permission check
            $roleId = $user->role_id;

            $expenseType = DB::table('expense_types')->where('id', '=', $injectedArgs['expenseType'])->first();
            if($expenseType == null) {
                return false;
            }
            if($expenseType->type == 'ReAccural') {
                $menu = DB::table('menus')->where('slug_name', '=', 'reaccruals')->first();
            } else {
                $menu = DB::table('menus')->where('slug_name', '=', 'expenses')->first();
            }
            if ( $roleId == null || $menu == null ) {
                return false;
            }
            $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
            if ( $roleMenu == null ) {
                return false;
            }
            $permission = $roleMenu->is_modify;
            if ( $permission == PermissionStatus::ALLOWED ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Expense $expense)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Expense $expense)
    {
        //
    }
}
