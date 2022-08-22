<?php

use App\Models\UnitType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->string('email_account')->after('payroll_password')->nullable();
            $table->dropColumn(['unit_type_id']);
        });
        
        Schema::table('units', function (Blueprint $table) {
            $table->integer('unit_type_id')->after('email_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn(['email_account', 'unit_type_id']);
        });

        Schema::table('units', function (Blueprint $table) {
            $table->integer('unit_type_id');
        });
    }
};
