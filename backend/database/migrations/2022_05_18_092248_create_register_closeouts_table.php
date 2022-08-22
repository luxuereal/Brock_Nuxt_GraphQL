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
        Schema::create('register_closeouts', function (Blueprint $table) {
            $table->id();
            $table->integer('unit_id');
            $table->integer('register_id');
            $table->string('non_resetable');
            $table->string('net_total');
            $table->string('last_non_resetable');
            $table->string('net_ov');
            $table->string('total_to_distribute');
            $table->string('net_charge');
            $table->string('tax_from_the_tape');
            $table->string('net_voucher');
            $table->string('overring_tax');
            $table->string('net_cash');
            $table->string('charge_tax');
            $table->string('voucher_tax');
            $table->string('cash_tax');
            $table->string('total_petty_cache');
            $table->string('actual_cache_deposit');
            $table->string('calculated_cache_deposit');
            $table->string('over_short');
            $table->string('customer_count_breakfast');
            $table->string('net_sales_breakfast');
            $table->string('customer_count_lunch');
            $table->string('net_sales_lunch');
            $table->string('customer_count_dinner');
            $table->string('net_sales_dinner');
            $table->string('customer_count_totals');
            $table->string('net_sales_totals');
            $table->date('close_date');
            $table->date('period_end');
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
        Schema::dropIfExists('register_closeouts');
    }
};


$table->string('totaltax');
$table->string('notoverring');
$table->string('nethousecharge');
$table->string('housechargetax');
$table->string('overshort');