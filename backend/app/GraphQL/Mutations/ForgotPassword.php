<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Enums\PasswordStatus;
use App\Exceptions\PasswordException;
use App\Services\Auth\ResetPasswordService;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Arr;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\Password;

class ForgotPassword
{
    public function __construct(
        protected ResetPasswordService $resetPasswordService
    )
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {       
        if (isset($args['reset_password_url'])) {
            $url = $args['reset_password_url'];

            $this->resetPasswordService->setResetPasswordUrl($args['reset_password_url']);
        }   

        $status = Password::sendResetLink(Arr::only($args, 'email'));

        if ($status === Password::RESET_LINK_SENT) {
            return [
                'status' => PasswordStatus::EMAIL_SENT,
                'message' => __($status)
            ];
        }

        throw new PasswordException(__('passwords.forgot-password-invalid'), __($status));
    }
}