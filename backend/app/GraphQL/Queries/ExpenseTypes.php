<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\ExpenseType;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Support\Facades\DB;

class ExpenseTypes
{   
    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        $expenseTypes = DB::table('expense_types')
            ->whereNot(function ($query) {
                $query->where('type', 'Fixed')
                    ->orWhere('type', 'OnCall')
                    ->orWhere('type', 'ReAccrual')
                    ->orWhere('type', 'Reversal');
            })
            ->where('available_on_dropdown', true)
            ->get();
        return $expenseTypes;
    }
}