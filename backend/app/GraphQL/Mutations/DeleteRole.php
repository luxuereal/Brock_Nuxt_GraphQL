<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\RoleMenu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DeleteRole
{

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::beginTransaction();
        try {
            // must delete RoleMenu first because it has role_id as Foreign key of roles table
            RoleMenu::where('role_id', $args['role_id'])->delete(); // Delete the permission for the Role from role_menus table
            Role::where('id', $args['role_id'])->delete(); // Delete the Role from roles table

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => false,
                'message' => __('remove_role_permission.error')
            ];
        }
        
        return [
            'status' => true,
            'message' => __('remove_role_permission.removed')
        ];
    }
}