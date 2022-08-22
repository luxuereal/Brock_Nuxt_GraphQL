<?php

declare(strict_types=1);

namespace App\Traits\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

trait ManagesAuth
{
    protected function userProvider(): UserProvider
    {
        $provider = config('auth.lighthouse-sanctum.provider');

        return Auth::createUserProvider($provider);
    }

    protected static function authenticatedUser()
    {
        $guard = config('lighthouse.guard');

        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            throw new AuthenticationException("Cannot retrieve an authenticated user.");
        }

        return $user;
    }
}