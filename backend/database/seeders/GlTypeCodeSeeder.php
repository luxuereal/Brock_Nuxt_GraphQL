<?php

namespace Database\Seeders;

use App\Models\GlTypeCode;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GlTypeCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlTypeCode::insert([
            ['code' => 'corp', 'description' => 'Corporate Use', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'expense', 'description' => 'Expenses and Purchase', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'foo', 'description' => 'Unknown', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'payroll', 'description' => 'Payroll', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'sales', 'description' => 'Sales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
