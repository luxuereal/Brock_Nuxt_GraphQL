<?php

namespace Database\Seeders;

use App\Models\CalculationCode;
use Illuminate\Database\Seeder;

class TruncateCalculationCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalculationCode::truncate();
    }
}
