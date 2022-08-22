<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Exceptions\LighthouseSanctum\ApiTokensException;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;;

class Logout
{
    use ManagesAuth;

    public function __construct()
    {

    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $user = static::authenticatedUser();

        if (!$user instanceof HasApiTokens) {
            throw new ApiTokensException($user);
        }

        $user->currentAccessToken()->delete();
        
        return [
            'status'  => 'TOKEN_REVOKED',
            'message' => __('auth.revoked')
        ];
    }
}
