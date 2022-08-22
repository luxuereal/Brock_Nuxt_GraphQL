<?php

namespace App\Policies;

use App\Models\CateringOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionStatus;

class CateringOrderPolicy
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
        $menu = DB::table('menus')->where('slug_name', '=', 'catering-sales')->first();
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
     * @param  \App\Models\CateringOrder  $cateringOrder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CateringOrder $cateringOrder)
    {
        // permission check
        if ($user->isAdministrator()) {
            return true;
        }

        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'catering-sales')->first();
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
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->isAdministrator()) {
            return true;
        } else {

            // permission check
            $roleId = $user->role_id;
            $menu = DB::table('menus')->where('slug_name', '=', 'catering-sales')->first();
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
     * @param  \App\Models\CateringOrder  $cateringOrder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CateringOrder $cateringOrder, array $injectedArgs)
    {
        // TODO: refactor
        if ($user->isAdministrator()) {
            return true;
        }

        $updateIds = array_column($injectedArgs['items']['update'] ?? [], 'id');

        $deleteIds = $injectedArgs['items']['delete'] ?? [];

        if ($user->activePeriod()?->id === $cateringOrder->period_id &&
            $user->id === $cateringOrder->user_id &&
            !$user->isAdministrator() &&
            $cateringOrder->containItems($updateIds) &&
            $cateringOrder->containItems($deleteIds)) {
            
            // permission check
            $roleId = $user->role_id;
            $menu = DB::table('menus')->where('slug_name', '=', 'catering-sales')->first();
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
     * @param  \App\Models\CateringOrder  $cateringOrder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CateringOrder $cateringOrder)
    {
        if ($user->isAdministrator()) {
            return true;
        }
        if ($user->activePeriod()?->id === $cateringOrder->period_id &&
            $user->id === $cateringOrder->user_id &&
            !$user->isAdministrator()) {
            
            // permission check
            $roleId = $user->role_id;
            $menu = DB::table('menus')->where('slug_name', '=', 'catering-sales')->first();
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
     * @param  \App\Models\CateringOrder  $cateringOrder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CateringOrder $cateringOrder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CateringOrder  $cateringOrder
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CateringOrder $cateringOrder)
    {
        //
    }
}
