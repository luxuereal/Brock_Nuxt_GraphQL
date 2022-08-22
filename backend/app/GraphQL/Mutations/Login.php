<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Exceptions\LighthouseSanctum\ApiTokensException;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\Contracts\HasApiTokens;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Login
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $userProvider = $this->userProvider();

        $user = $userProvider->retrieveByCredentials([
            'email' => $args['email'],
            'password' => $args['password']
        ]);

        if (!$user || !$userProvider->validateCredentials($user, $args)) {
            throw new AuthenticationException("These credentials do not match our records.");
        }

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            throw new AuthenticationException("The provided email is not verified.");
        }
        
        if (!$user instanceof HasApiTokens) {
            throw new ApiTokensException($user);
        }

        // $user->tokens()->delete();

        return [
            "token" => $user->createToken('default')->plainTextToken
        ];
    }
}