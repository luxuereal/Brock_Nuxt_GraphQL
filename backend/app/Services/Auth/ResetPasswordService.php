<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;

class ResetPasswordService
{
    public function __construct(
        protected Hasher $hash,
        protected Dispatcher $dispatcher
    )
    {
        
    }

    public function setResetPasswordUrl(string $url): void
    {
        ResetPasswordNotification::createUrlUsing(fn($user, string $token) => $this->buildResetpPasswordUrl($user->email, $token, $url));
    }

    public function buildResetpPasswordUrl(string $email, string $token, string $url): string
    {
        return str_replace([
            '__EMAIL__',
            '__TOKEN__'
        ],
        [
            $email,
            $token
        ], $url);
    }

    public function resetPassword(Authenticatable $user, string $password)
    {
        $user->forceFill([
            'password' => $this->hash->make($password)
        ])->save();

        $this->dispatcher->dispatch(new PasswordReset($user));
    }
}