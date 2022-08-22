<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TruncateBrockDataSeeder::class,
            //
            ExpenseTypeSeeder::class,
            TermSeeder::class,
            RegisterTypeSeeder::class,
            DistrictSeeder::class,
            CalculationCodeSeeder::class,
            //
            StateSeeder::class,
            CitySeeder::class,
            CountySeeder::class,
            //
            GlTypeCodeSeeder::class,
            GlAccountSeeder::class,
            GlSubAccountSeeder::class,
            InventoryCategorySeeder::class,
            GlAccountDropOldSeeder::class,
        ]);
    }
}
