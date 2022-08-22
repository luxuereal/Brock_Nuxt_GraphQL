<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use App\Traits\Auth\ManagesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Storage;

class UpdateProfile
{
    use ManagesAuth;

    public function __construct()
    {
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        DB::beginTransaction();
        try {
            $user = static::authenticatedUser();

            $users = User::where('id', '!=', $user->id)->where('email', $args['email'])->get();
            if ( count($users) != 0 ) {
                return [
                    'status' => false,
                    'message' => 'The email already exists'
                ];
            }

            $user->first_name = $args['first_name'];
            $user->last_name = $args['last_name'];
            $user->email = $args['email'];

            if ( $args['password'] != '' ) {
                $user->password = Hash::make($args['password']);
            }
        
            $upload_url = '';
            if ( $args['avatar'] != null ) {
                $file = $args['avatar'];
                $upload_url = $file->storePublicly('uploads');
                Storage::move($upload_url, 'public/' . $upload_url);

                // unlink the avatar already exists
                if ( $user->avatar != null ) {
                    $userPhoto = 'public/'.$user->avatar;
                    if(Storage::exists($userPhoto)){
                        Storage::delete($userPhoto); // then delete previous photo
                    }
                }

                $user->avatar = $upload_url;
            }
            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => false,
                'message' => 'error'
            ];
        }
        
        return [
            'status' => true,
            'message' => $upload_url
        ];
    }
}