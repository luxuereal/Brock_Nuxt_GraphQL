<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\RoleMenu;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Enums\UserUpdateStatus;

class UpdateRole
{

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::beginTransaction();
        try {
            // check if the role exists
            $role = Role::where('id', $args['role_id'])->first();
            if ( $role == null ) {
                return [
                    'status' => false,
                    'message' => "That role doesn't exist"
                ];
            }

            $sameRoleNameCount = Role::where('id', '!=', $args['role_id'])->where('name', $args['role_name'])->count();
            if ( $sameRoleNameCount > 0 ) {
                return [
                    'status' => false,
                    'message' => "The roleName should be unique"
                ];
            }

            $menus = Menu::all();
            foreach ( $menus as $menu ) {
                $hasPermission[$menu->id] = false;
            }

            // update the role
            $role->name = $args['role_name'];
            $role->save();

            // update permissions
            foreach ( $args['permissions'] as $permission ) {
                $hasPermission[$permission['menu_id']] = true;
                // check if the role-menu permission exists
                $roleMenu = RoleMenu::where('role_id', $args['role_id'])->where('menu_id', $permission['menu_id'])->first();
                if ( $roleMenu == null ) {
                    DB::rollback();
                    return [
                        'status' => false,
                        'message' => "Unknown menuID"
                    ];
                } else {
                    // update role_menus table
                    $roleMenu->is_view = $permission['is_view'];
                    $roleMenu->is_create = $permission['is_create'];
                    $roleMenu->is_modify = $permission['is_modify'];
                    $roleMenu->save();
                }
            }

            // check if the input has the permissions for all of the menus
            foreach ( $menus as $menu ) {
                if ( $hasPermission[$menu->id] == false ) {
                    DB::rollback();
                    return [
                        'status' => false,
                        'message' => "Didn't set the permission for all of the menus"
                    ];
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => false,
                'message' => __('update_role_permission.error')
            ];
        }
        
        return [
            'status' => true,
            'message' => __('update_role_permission.updated')
        ];
    }
}