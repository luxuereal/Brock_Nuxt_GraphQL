<?php

namespace App\GraphQL\Mutations;

use App\Models\CateringOrder;
use App\Models\CateringOrderItem;
use Illuminate\Support\Facades\DB;

class UpdateCateringOrder
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        try {
            //begin transaction
            DB::beginTransaction();
            
            //requested for update catering order items
            $cateringOrderItems = $args['items']['update'] ?? [];
            
            //requested for update catering order items ids
            $cateringOrderItemIds = \array_column($cateringOrderItems, 'id');
            
            // updating catering order items
            if (!empty($cateringOrderItems)) {
                foreach ($cateringOrderItems as $cateringOrderItem) {
                    CateringOrderItem::where('id', $cateringOrderItem['id'])->update(
                        $cateringOrderItem
                    );
                }
            }
            
            //cateringOrder
            $cateringOrder = CateringOrder::with('items')->findOrFail($args['id']);
            
            //calculating new price for catering order
            $price = 0;
            foreach ($cateringOrder->items as $item) {
                $price += $item['quantity'] * $item['price'];
            }
            $args['price'] = $price;
            
            //updating catering order
            unset($args['items']);
            $cateringOrder->fill($args)->save();
            
            //existing catering order items ids
            $currentCateringOrderItemIds = $cateringOrder->items->pluck('id')->toArray();
            
            //diff between 'requested for update catering order items ids' and 'existing catering order items ids'
            $cateringOrderItemIdsToDelete = array_diff($currentCateringOrderItemIds, $cateringOrderItemIds);
            
            //removing deprecated items
            if (!empty($cateringOrderItemIdsToDelete)) {
                CateringOrderItem::where('catering_order_id', $args['id'])
                    ->whereIn('id', $cateringOrderItemIdsToDelete)
                    ->delete();
            }
            
            //commit
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            return false;
        }
        
        return $cateringOrder;
    }
}
