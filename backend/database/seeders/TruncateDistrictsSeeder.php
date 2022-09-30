<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class TruncateDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::truncate();
    }
}
