<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;

class TruncateCountiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        County::truncate();
    }
}
