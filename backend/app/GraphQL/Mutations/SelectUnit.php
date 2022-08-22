<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Unit;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SelectUnit
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $unit = Unit::findOrFail($args['id']);

        $user = static::authenticatedUser();

        $selectedUnit = $user->selectedUnit();

        if ($selectedUnit && $selectedUnit !== $unit) {
            $user->units()->updateExistingPivot($selectedUnit->id, [
                'selected' => false
            ]);
        }

        $user->units()->updateExistingPivot($unit->id, [
            'selected' => true
        ]);

        return $unit;
    }
}