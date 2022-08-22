<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Enums\UserUpdateStatus;

class UpdateUser
{

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::beginTransaction();
        try {
            $is_admin = $args['is_admin'];
            if ( $is_admin == false ) {
                $role = Role::findOrFail($args['role_id']);
            }

            $user = User::findOrFail($args['id']);
            $wasAdmin = $user->is_admin;
            if (isset($args['password'])) {
                $args['password'] = Hash::make($args['password']);
            }
            $user->fill($args)->save();
            if ( $is_admin == true ) {
                $user->role_id = null;
                $user->save();
            }

            if ( !$user->is_admin ) {
                if ( empty($args['units']['sync']) ) {
                    DB::rollback();
                    return [
                        'status' => UserUpdateStatus::ERROR,
                        'message' => 'You should select units'
                    ];
                } else {
                    $user->units()->sync($args['units']['sync']);
                }
            } elseif ( !$wasAdmin ) {
                $user->units()->detach();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => UserUpdateStatus::ERROR,
                'message' => __('update_user.error')
            ];
        }
        
        return [
            'status' => UserUpdateStatus::UPDATED,
            'message' => __('update_user.updated')
        ];
    }
}
