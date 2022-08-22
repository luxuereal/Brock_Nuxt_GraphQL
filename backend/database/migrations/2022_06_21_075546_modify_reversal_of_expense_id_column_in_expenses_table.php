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
//        Schema::table('expenses', function (Blueprint $table) {
//            $table->unsignedBigInteger('reversal_of_expense_id')->nullable()->change();
//            $table->foreign('reversal_of_expense_id')->references('id')->on('expenses')->nullOnDelete();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('expenses', function (Blueprint $table) {
//            $table->dropForeign(['reversal_of_expense_id']);
//        });
    }
};
