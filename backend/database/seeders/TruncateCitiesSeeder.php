<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class TruncateCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::truncate();
    }
}
