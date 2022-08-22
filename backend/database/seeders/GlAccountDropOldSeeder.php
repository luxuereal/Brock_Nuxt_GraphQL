<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GlAccountDropOldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::table('gl_accounts', function (Blueprint $table) {
            $table->dropColumn('old_id');
        });
    }
}
