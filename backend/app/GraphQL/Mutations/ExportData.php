<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ExportData
{   
    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TO-DO PECZIS export purchases/catering

        // uncomment to add gate policy
        // Gate::allowIf(fn ($user) => $user->isAdministrator());

        return url('/');
    }
}