<?php

namespace Database\Seeders;

use App\Models\GlTypeCode;
use Illuminate\Database\Seeder;

class TruncateGlTypeCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GlTypeCode::truncate();
    }
}
