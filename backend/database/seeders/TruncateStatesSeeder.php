<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class TruncateStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::truncate();
    }
}
