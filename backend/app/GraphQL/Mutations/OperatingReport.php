<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Gate;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

use App\Models\Unit;
use App\Models\Period;

use App\Enums\OperatingPeriodType;
use App\Enums\OperatingType;
use App\Enums\PermissionStatus;

class OperatingReport
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        // TO-DO

        // uncomment to add gate policy
        // use policy logic here, cause we can't apply separate class to that (it's not a resource)

        // retrieve user
        $user = static::authenticatedUser();

        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'reports')->first();
        if ( $roleId == null || $menu == null ) {
            return url("/");
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return url("/");
        }
        $permission = $roleMenu->is_create;

        if ( $permission == PermissionStatus::NOTALLOWED ) {
            return url("/");
        }
        
        // Gate::allowIf(fn ($user) => $user->isAdministrator());

        $userId = $user->id;
        
        $periodId = $args['period'];
        $period = Period::findOrFail($periodId);

        $unitId = $args['unit'];
        $unit = Unit::findOrFail($unitId);

        $type = $args['type'];
        $typePeriod = $args['typePeriod'];

        /* $type
        const WEEKLY = 'weekly';
        const MONTHLY = 'monthly';
        */
        if ( $type == OperatingPeriodType::WEEKLY ) {
            return url("weekly_report");
        } else if ( $type == OperatingPeriodType::MONTHLY ) {
            return url("monthly_report");
        }

        /* $typePeriod
        const OPERATING = 'operating';
        const COMPLETE = 'complete';
        const CATERING = 'catering';
        const CATERING_STATISTICS = 'catering-statistics';
        const INVENTORY = 'inventory';
        const PURCHASE = 'purchase';
        const CLOSEOUT = 'closeout';
        const EXPENSE = 'expense';
        const LABOR = 'labor';
        */

        return url("userId:{$userId},periodId:{$periodId},unitId:{$unitId},type:{$type},typePeriod:{$typePeriod}");
    }
}