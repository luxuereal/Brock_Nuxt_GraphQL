<?php

declare(strict_types=1);

namespace App\GraphQL\Queries\Fields;

use App\Models\InventoryCategory;
use App\Traits\Auth\ManagesAuth;

class InventoryAmount
{   
    use ManagesAuth;

    public function __construct()
    {
        
    }

    public function __invoke(InventoryCategory $inventoryCategory)
    {   
        $user = static::authenticatedUser();

        $selectedUnit = $user->selectedUnit();

        if ( $selectedUnit == null ) {
            return [
                'current' => 0,
                'previous' => 0
            ];
        }

        $activePeriod = $selectedUnit->activePeriod();

        return [
            'current' => $inventoryCategory->inventoryAmount($selectedUnit->id, $activePeriod?->id),
            'previous' => $inventoryCategory->inventoryAmount($selectedUnit->id, $activePeriod->previous()?->id)
        ];
    }
}