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
        Schema::table('register_closeouts', function (Blueprint $table) {
            $table->renameColumn('net_ov', 'net_o_v');
            $table->renameColumn('overring_tax', 'overring_void_tax');
            $table->renameColumn('total_petty_cache', 'total_petty_cash');
            $table->renameColumn('actual_cache_deposit', 'actual_cash_deposit');
            $table->renameColumn('calculated_cache_deposit', 'calculated_cash_deposit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_closeouts', function (Blueprint $table) {
            $table->renameColumn('net_o_v', 'net_ov');
            $table->renameColumn('overring_void_tax', 'overring_tax');
            $table->renameColumn('total_petty_cash', 'total_petty_cache');
            $table->renameColumn('actual_cash_deposit', 'actual_cache_deposit');
            $table->renameColumn('calculated_cash_deposit', 'calculated_cache_deposit');
        });
    }
};
