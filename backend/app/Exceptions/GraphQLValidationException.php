<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

class GraphQLValidationException extends Exception implements RendersErrorsExtensions
{
    public function __construct(
        protected string $validationMessage, 
        protected string $field,
        ResolveInfo $path
    )
    {   
        $path = implode('.', $path->path);

        parent::__construct("Validation failed for the field [{$path}].");
    }

    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'validation';
    }

    public function extensionsContent(): array
    {
        return [
            'validation' => [
                "input.{$this->field}" => [$this->validationMessage],
            ],
        ];
    }
}