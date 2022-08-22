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
        Schema::create('catering_orders', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->dateTime('delivery_date');
            $table->integer('head_count');
            $table->string('phone_number');
            $table->string('order_by');
            $table->string('order_for');
            $table->date('order_date');
            $table->boolean('is_taxable');
            $table->decimal('price', 8, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('ship_to_name');
            $table->string('ship_to_address');
            $table->string('bill_to_name');
            $table->string('bill_to_address');
            $table->boolean('is_cash_order');
            $table->string('charge_number');
            //foreign keys
            $table->integer('unit_id');
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
        Schema::dropIfExists('catering_orders');
    }
};
