<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TruncateBrockDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            TruncateExpenseTypesSeeder::class,
            TruncateTermsSeeder::class,
            TruncateRegisterTypesSeeder::class,
            TruncateDistrictsSeeder::class,
            TruncateCalculationCodesSeeder::class,
            //
            TruncateCountiesSeeder::class,
            TruncateCitiesSeeder::class,
            TruncateStatesSeeder::class,
            //
            TruncateInventoryCategoriesSeeder::class,
            TruncateGlAccountUnitsSeeder::class,
            TruncateGlAccountsSeeder::class,
            TruncateGlTypeCodesSeeder::class,
        ]);
    }
}
