<?php

namespace App\GraphQL\Mutations;

use App\Models\CateringOrder;
use Illuminate\Support\Facades\DB;

class CreateCateringOrder
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {        
        $cateringOrderItems = $args['items']['create'] ?? [];
        
        $cateringOrderPrice = 0;
        if (!empty($cateringOrderItems)) {
            foreach ($cateringOrderItems as $cateringOrderItem) {
                $cateringOrderPrice += ($cateringOrderItem['price'] + $cateringOrderItem['ext']) * $cateringOrderItem['quantity'];
            }
        }
        
        unset($args['items']);
        
        $args['price'] = $cateringOrderPrice;
        
        try {
            DB::beginTransaction();
            
            $cateringOrder = CateringOrder::create($args);
            
            if ($cateringOrderItems) {
                $cateringOrder->items()->createMany($cateringOrderItems);
            }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return false;
        }
        
        return $cateringOrder;
    }
}
