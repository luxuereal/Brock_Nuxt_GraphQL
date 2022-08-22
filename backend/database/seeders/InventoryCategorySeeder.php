<?php

namespace Database\Seeders;

use App\Models\InventoryCategory;
use Illuminate\Database\Seeder;

class InventoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inventoryCategories = [
            ['name' => 'Meat', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Unit Supplies', 'gl' => 5300, 'glsub' => 24, 'vending' => 'N'],
            ['name' => 'Candy/Snack', 'gl' => 5030, 'glsub' => 1, 'vending' => 'Y'],
            ['name' => 'Hot Food', 'gl' => 5030, 'glsub' => 2, 'vending' => 'Y'],
            ['name' => 'Hot Drink', 'gl' => 5030, 'glsub' => 3, 'vending' => 'Y'],
            ['name' => 'Cold Food', 'gl' => 5030, 'glsub' => 4, 'vending' => 'Y'],
            ['name' => 'Frozen Food', 'gl' => 5030, 'glsub' => 5, 'vending' => 'Y'],
            ['name' => 'Bottle Drink', 'gl' => 5030, 'glsub' => 6, 'vending' => 'Y'],
            ['name' => 'Canned Soda', 'gl' => 5030, 'glsub' => 7, 'vending' => 'Y'],
            ['name' => 'Juice Canned', 'gl' => 5030, 'glsub' => 8, 'vending' => 'Y'],
            ['name' => 'Fresh Produce', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Groceries', 'gl' => 5000, 'glsub' => 0, 'vending' => 'B'],
            ['name' => 'Dairy', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Bakery', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Daily Bread', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Coffee', 'gl' => 5000, 'glsub' => 0, 'vending' => 'B'],
            ['name' => 'Bottled and Canned Beverage', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Fountain Beverage', 'gl' => 5000, 'glsub' => 0, 'vending' => 'N'],
            ['name' => 'Convenience Store', 'gl' => 5000, 'glsub' => 0, 'vending' => 'B'],
            ['name' => 'Paper', 'gl' => 5100, 'glsub' => 0, 'vending' => 'B'],
            ['name' => 'Cleaning', 'gl' => 5300, 'glsub' => 2, 'vending' => 'B'],
        ];

        foreach ($inventoryCategories as $inventoryCategory) {
            $glAccount = \App\Models\GlAccount::where('old_id', $inventoryCategory['gl'])->whereNull('parent_id')->first();
            $glSubAccount = \App\Models\GlAccount::where('old_id', $inventoryCategory['glsub'])->where('parent_id', $glAccount->id)->first();

            InventoryCategory::create([
                'name'          => $inventoryCategory['name'],
                'gl_account_id' => $glSubAccount ? $glSubAccount->id : ($glAccount ? $glAccount->id : NULL),
                'vending'       => $inventoryCategory['vending'],
            ]);
        }
    }
}
