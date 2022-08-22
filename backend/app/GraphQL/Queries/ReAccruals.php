<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Expense;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class ReAccruals
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        Gate::allowIf(fn ($user) => !$user->isAdministrator());

        $user = static::authenticatedUser();

        $previousPeriod = $user->activePeriod()?->previous();

        $reAccruals = $user->expenses()
            ->where('period_id', $previousPeriod?->id)
            ->whereHas('expenseType', function(Builder $query) {
                $query->where('type', 'Accrual')
                    ->orWhere('type', 'ReAccrual');
            })
            ->doesntHave('reversals')
            ->get();

        return $reAccruals;
    }
}