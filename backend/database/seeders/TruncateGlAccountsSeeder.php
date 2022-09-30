<?php

namespace Database\Seeders;

use App\Models\GlAccount;
use Illuminate\Database\Seeder;

class TruncateGlAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlAccount::truncate();
    }
}
