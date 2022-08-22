<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\Inventory;
use App\Models\InventoryCategory;
use App\Traits\Auth\ManagesAuth;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\Enums\PermissionStatus;

class UpdateInventories
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {   
        Gate::allowIf(fn ($user) => !$user->isAdministrator() && $user->hasSelectedUnit());

        $user = static::authenticatedUser();

        $selectedUnit = $user->selectedUnit();

        $activePeriod = $selectedUnit->activePeriod();

        // permission check
        $roleId = $user->role_id;
        $menu = DB::table('menus')->where('slug_name', '=', 'inventory')->first();
        if ( $roleId == null || $menu == null ) {
            return [
                'status' => false,
                'message' => 'Unknown SlugName',
                'category' => InventoryCategory::all()
            ];
        }
        $roleMenu = DB::table('role_menus')->where('role_id', '=', $roleId)->where('menu_id', '=', $menu->id)->first();
        if ( $roleMenu == null ) {
            return [
                'status' => false,
                'message' => 'Unknown Permission',
                'category' => InventoryCategory::all()
            ];
        }
        $permission = $roleMenu->is_modify;

        if ( $permission == PermissionStatus::NOTALLOWED ) {
            return [
                'status' => false,
                'message' => 'You must have a modify permission',
                'category' => InventoryCategory::all()
            ];
        }

        foreach($args['inventoriesInput'] as $inventoryInput) {
            Inventory::updateOrCreate(
                [   
                    'inventory_category_id' => $inventoryInput['id'],
                    'period_id' => $activePeriod->id, 
                    'unit_id' => $selectedUnit->id, 
                ],
                [
                    'amount' => $inventoryInput['amount']
                ]
            );
        }

        return [
            'status' => true,
            'category' => InventoryCategory::all()
        ];
    }
}