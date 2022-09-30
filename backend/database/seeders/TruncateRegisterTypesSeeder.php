<?php

namespace Database\Seeders;

use App\Models\RegisterType;
use Illuminate\Database\Seeder;

class TruncateRegisterTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RegisterType::truncate();
    }
}
