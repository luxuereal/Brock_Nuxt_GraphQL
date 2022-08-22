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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('sales_tax_cafeteria', 4, 2);
            $table->decimal('sales_tax_vending', 4, 2);
            $table->decimal('sales_tax_restaurant', 4, 2);
            $table->decimal('sales_tax_store', 4, 2);
            $table->decimal('gross_receipts_tax', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
