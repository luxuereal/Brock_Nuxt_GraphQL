<?php

namespace Database\Seeders;

use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::insert([
            ['code' => 'CO', 'sales_tax_cafeteria' => '0.04', 'sales_tax_vending' => '0.029', 'sales_tax_restaurant' => '0.029', 'sales_tax_store' => '0.029', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CT', 'sales_tax_cafeteria' => '0', 'sales_tax_vending' => '0', 'sales_tax_restaurant' => '0', 'sales_tax_store' => '0', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'DC', 'sales_tax_cafeteria' => '0.1', 'sales_tax_vending' => '0.0575', 'sales_tax_restaurant' => '0.1', 'sales_tax_store' => '0.1', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'DE', 'sales_tax_cafeteria' => '0', 'sales_tax_vending' => '0', 'sales_tax_restaurant' => '0', 'sales_tax_store' => '0', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'MA', 'sales_tax_cafeteria' => '0', 'sales_tax_vending' => '0', 'sales_tax_restaurant' => '0', 'sales_tax_store' => '0', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'MD', 'sales_tax_cafeteria' => '0.06', 'sales_tax_vending' => '0.06', 'sales_tax_restaurant' => '0.06', 'sales_tax_store' => '0.06', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NC', 'sales_tax_cafeteria' => '0.0725', 'sales_tax_vending' => '0.0725', 'sales_tax_restaurant' => '0.0725', 'sales_tax_store' => '0.0725', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NJ', 'sales_tax_cafeteria' => '0.06625', 'sales_tax_vending' => '0.06625', 'sales_tax_restaurant' => '0.06625', 'sales_tax_store' => '0.06625', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NY', 'sales_tax_cafeteria' => '0.0825', 'sales_tax_vending' => '0.0825', 'sales_tax_restaurant' => '0.0825', 'sales_tax_store' => '0.0825', 'gross_receipts_tax' => '0.0825', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'PA', 'sales_tax_cafeteria' => '0.06', 'sales_tax_vending' => '0.06', 'sales_tax_restaurant' => '0.06', 'sales_tax_store' => '0.06', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'RI', 'sales_tax_cafeteria' => '0', 'sales_tax_vending' => '0', 'sales_tax_restaurant' => '0', 'sales_tax_store' => '0', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'VA', 'sales_tax_cafeteria' => '0.06', 'sales_tax_vending' => '0.06', 'sales_tax_restaurant' => '0.06', 'sales_tax_store' => '0.06', 'gross_receipts_tax' => '0.06', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'VT', 'sales_tax_cafeteria' => '0', 'sales_tax_vending' => '0', 'sales_tax_restaurant' => '0', 'sales_tax_store' => '0', 'gross_receipts_tax' => '0', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
