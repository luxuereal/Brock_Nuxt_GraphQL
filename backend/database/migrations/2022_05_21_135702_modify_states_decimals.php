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
        Schema::table('states', function (Blueprint $table) {
            $table->decimal('sales_tax_cafeteria', 9, 6)->change();
            $table->decimal('sales_tax_vending', 9, 6)->change();
            $table->decimal('sales_tax_restaurant', 9, 6)->change();
            $table->decimal('sales_tax_store', 9, 6)->change();
            $table->decimal('gross_receipts_tax', 9, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
