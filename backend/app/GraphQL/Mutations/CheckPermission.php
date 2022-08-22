<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\RoleMenu;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use App\Traits\Auth\ManagesAuth;
use App\Enums\PermissionType;

class CheckPermission
{
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        try {
            $user = static::authenticatedUser();
            $slugName = $args['slug_name'];
            $permissionType = $args['permission_type'];
            
            $menu = Menu::where('slug_name', $slugName)->first();
            if ( $menu == null ) {
                return [
                    'status' => false,
                    'message' => 'Unknown slugName'
                ];
            }

            if ( $user->is_admin ) {
                return [
                    'status' => true,
                    'permission' => true,
                    'message' => 'You are admin'
                ];
            }
            
            // get the User Role SlugName permission
            $roleMenu = RoleMenu::where('role_id', $user->role_id)->where('menu_id', $menu->id)->first();
            if ( $roleMenu == null ) {
                return [
                    'status' => false,
                    'message' => 'Unknown Permission'
                ];
            }

            // get the allow of the permissionType
            if ( $permissionType == PermissionType::VIEW ) {
                $permission = $roleMenu->is_view;
            } else if ( $permissionType == PermissionType::CREATE ) {
                $permission = $roleMenu->is_create;
            } else if ( $permissionType == PermissionType::MODIFY ) {
                $permission = $roleMenu->is_modify;
            } else {
                return [
                    'status' => false,
                    'message' => 'Unknown permissionType'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => __('Unknown Error')
            ];
        }
        
        return [
            'status' => true,
            'permission' => $permission,
            'message' => $permission ? 'Allowed' : 'Not Allowed'
        ];
    }
}