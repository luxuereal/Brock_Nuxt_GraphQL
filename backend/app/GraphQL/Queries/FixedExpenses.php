<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\FixedExpense;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

use App\Traits\Auth\ManagesAuth;

class FixedExpenses
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $user = static::authenticatedUser();
        $selectedUnit = $user->selectedUnit();
        
        $fixedExpenses = FixedExpense::where('unit_id', $selectedUnit->id)->get();

        return $fixedExpenses;
    }
}