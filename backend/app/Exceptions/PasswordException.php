<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class PasswordException extends Exception implements RendersErrorsExtensions
{   
    /**
     * @param string $status
     */
    public function __construct(
        $message,
        protected string $status
    )
    {
        parent::__construct($message);
    }

    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'password';
    }

    public function extensionsContent(): array
    {
        return [
            'status' => $this->status
        ];
    }
}