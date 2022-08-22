<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Enums\PasswordStatus;
use App\Exceptions\PasswordException;
use App\Services\Auth\ResetPasswordService;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Password;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ResetPassword
{   
    public function __construct(
        protected ResetPasswordService $resetPasswordService
    )
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $status = Password::reset($args, function(Authenticatable $user, string $password) {
            $this->resetPasswordService->resetPassword($user, $password);
        });

        if ($status === Password::PASSWORD_RESET) {
            return [
                'status'=> PasswordStatus::PASSWORD_RESET,
                'message' => __($status)
            ];
        }

        throw new PasswordException(__('passwords.reset-password-invalid'), __($status));
    }
}