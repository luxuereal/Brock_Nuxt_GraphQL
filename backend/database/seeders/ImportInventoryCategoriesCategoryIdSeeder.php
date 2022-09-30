<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImportInventoryCategoriesCategoryIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '100;Meat;5000;000;N',
            '1000;Unit Supplies;5300;024;N',
            '1100;Candy/Snack;5030;001;Y',
            '1200;Hot Food;5030;002;Y',
            '1300;Hot Drink;5030;003;Y',
            '1400;Cold Food;5030;004;Y',
            '1500;Frozen Food;5030;005;Y',
            '1600;Bottle Drink;5030;006;Y',
            '1700;Canned Soda;5030;007;Y',
            '1800;Juice Canned;5030;008;Y',
            '200;Fresh Produce;5000;000;N',
            '300;Groceries;5000;000;B',
            '400;Dairy;5000;000;N',
            '500;Bakery;5000;000;N',
            '501;Daily Bread;5000;000;N',
            '600;Coffee;5000;000;B',
            '601;Bottled and Canned Beverage;5000;000;N',
            '602;Fountain Beverage;5000;000;N',
            '700;Convenience Store;5000;000;B',
            '800;Paper;5100;000;B',
            '900;Cleaning;5300;002;B',
        ];
∑
        foreach($data as $dataItem) {
            $item = explode(';', $dataItem);

            $inventoryCategory = \App\Models\InventoryCategory::where('name', $item[1])->first();

            $inventoryCategory->item_id = $item[0];
            $inventoryCategory->save();
        }
    }
}
