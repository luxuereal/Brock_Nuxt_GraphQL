<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('unit_periods', function (Blueprint $table) {
            $table->dropForeign('unit_periods_unit_id_foreign');
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();

            $table->dropForeign('unit_periods_period_id_foreign');
            $table->unsignedBigInteger('period_id')->nullable()->change();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_periods', function (Blueprint $table) {
            //
        });
    }
};
