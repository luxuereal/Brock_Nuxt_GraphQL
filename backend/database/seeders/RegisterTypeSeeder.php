<?php

namespace Database\Seeders;

use App\Models\RegisterType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RegisterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegisterType::insert([
            ['name' => 'cafeteria', 'description' => 'Cafeteria', 'tax_type' => 'salestaxcafe', 'is_vending' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'cstore', 'description' => 'Convenience Store', 'tax_type' => 'salestaxcstore', 'is_vending' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'mealcount', 'description' => 'Meal Count', 'tax_type' => 'salestaxcafe', 'is_vending' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'restaurant', 'description' => 'Restaurant', 'tax_type' => 'salestaxrest', 'is_vending' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'vending', 'description' => 'Vending', 'tax_type' => 'salestaxvend', 'is_vending' => false, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
