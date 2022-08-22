<?php

namespace Database\Seeders;

use App\Models\CalculationCode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CalculationCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculationCode::insert([
            ['code' => 'amtmo', 'description' => 'dollars per month', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'amtwk', 'description' => 'dollars per week', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'perwkmin', 'description' => 'percentage per week with minimum', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'perwknomin', 'description' => 'percentage per week', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
