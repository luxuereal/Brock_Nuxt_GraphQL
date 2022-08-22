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
        Schema::create('catering_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('catering_order_id');
            $table->string('menu_item');
            $table->integer('quantity');
            $table->decimal('price');
            $table->decimal('ext');
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
        Schema::dropIfExists('catering_order_items');
    }
};
