<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Enums\UserCreateStatus;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateUser
{

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::beginTransaction();
        try {
            $is_admin = $args['is_admin'];
            if ( !$is_admin ) {
                $role = Role::findOrFail($args['role_id']);
            }
            $user = new User();
            $user->first_name = $args['first_name'];
            $user->last_name = $args['last_name'];
            $user->email = $args['email'];
            $user->is_admin = $args['is_admin'];
            $user->is_active = $args['is_active'];
            $user->email_verified_at = now();
            $user->password = Hash::make($args['password']);
            if ( !$is_admin ) {
                $user->role_id = $args['role_id'];
            }
            $user->save();
            
            if ( !$user->is_admin ) {
                if ( empty($args['units']['sync']) ) {
                    DB::rollback();
                    return [
                        'status' => UserCreateStatus::ERROR,
                        'message' => 'You should select units'
                    ];
                } else {
                    $user->units()->sync($args['units']['sync']);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => UserCreateStatus::ERROR,
                'message' => __('create_user.error')
            ];
        }
        
        return [
            'status' => UserCreateStatus::CREATED,
            'message' => __('create_user.created')
        ];
    }
}
