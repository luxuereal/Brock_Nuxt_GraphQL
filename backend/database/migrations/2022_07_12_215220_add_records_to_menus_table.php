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
        Schema::table('menus', function (Blueprint $table) {
            //
        });
        DB::table('menus')->insert([
            [
                'name' => 'Close Register (in Home and Review)',
                'slug_name' => 'close-register'
            ],
            [
                'name' => 'Catering Sales (in Home and Review)',
                'slug_name' => 'catering-sales'
            ],
            [
                'name' => 'Purchases (in Home and Review)',
                'slug_name' => 'purchase-orders'
            ],
            [
                'name' => 'Expenses (in Home and Review)',
                'slug_name' => 'expenses'
            ],
            [
                'name' => 'Inventory',
                'slug_name' => 'inventory'
            ],
            [
                'name' => 'On-Call Labor',
                'slug_name' => 'on-call-labor'
            ],
            [
                'name' => 'ReAccruals',
                'slug_name' => 'reaccruals'
            ],
            [
                'name' => 'Reports',
                'slug_name' => 'reports'
            ],
            [
                'name' => 'Fixed Expense',
                'slug_name' => 'fixed-expense'
            ],
            [
                'name' => 'Close week',
                'slug_name' => 'close-week'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            //
        });
    }
};
