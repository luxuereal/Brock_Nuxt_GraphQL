<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Expense;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\Role;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Enums\PermissionType;

class RolePrivileges
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }
    /* 
        rolePrivileges: [
        {
            'slugName': 'close-register',
            'permissionType': 'CREATE'
        },
        {
            'slugName': 'close-register',
            'permissionType': 'VIEW'
        },
        {
            'slugName': 'purchase-orders',
            'permissionType': 'MODIFY'
        }
        ]
    */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $user = static::authenticatedUser();

        $role = Role::where('id', $user->role_id)->first();
        $response = [];
        if ( $role != null ) {
            $roleMenus = RoleMenu::where('role_id', $role->id)->get();
            foreach ( $roleMenus as $roleMenu ) {
                $menu = Menu::where('id', $roleMenu->menu_id)->first();
                $slugName = $menu->slug_name;

                if ( $roleMenu->is_view ) {
                    array_push($response, array(
                        'slugName' => $slugName,
                        'permissionType' => PermissionType::VIEW
                    ));
                }
                if ( $roleMenu->is_create ) {
                    array_push($response, array(
                        'slugName' => $slugName,
                        'permissionType' => PermissionType::CREATE
                    ));
                }
                if ( $roleMenu->is_modify ) {
                    array_push($response, array(
                        'slugName' => $slugName,
                        'permissionType' => PermissionType::MODIFY
                    ));
                }
            }
        }
        return $response;
    }
}