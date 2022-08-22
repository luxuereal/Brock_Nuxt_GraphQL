<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Period;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

class PeriodsActive
{   
    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $currentDate = date('Y-m-d');
        $activePeriods = Period::where('period_end', '>=', $currentDate)->orderBy('period_end')->get();

        return $activePeriods;
    }
}