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
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('period_id')->nullable()->change();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
            $table->unsignedBigInteger('inventory_category_id')->nullable()->change();
            $table->foreign('inventory_category_id')->references('id')->on('inventory_categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['period_id']);
            $table->dropForeign(['inventory_category_id']);
        });
    }
};
