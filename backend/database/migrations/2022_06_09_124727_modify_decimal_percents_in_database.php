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
        Schema::table('cities', function (Blueprint $table) {
            $table->decimal('tax', 5, 2)->change();
        });

        Schema::table('counties', function (Blueprint $table) {
            $table->decimal('tax', 5, 2)->change();
        });

        Schema::table('states', function (Blueprint $table) {
            $table->decimal('sales_tax_cafeteria', 5, 2)->change();
            $table->decimal('sales_tax_vending', 5, 2)->change();
            $table->decimal('sales_tax_restaurant', 5, 2)->change();
            $table->decimal('sales_tax_store', 5, 2)->change();
            $table->decimal('gross_receipts_tax', 5, 2)->change();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->decimal('management_percent', 5, 2)->change();
            $table->decimal('administrative_percent', 5, 2)->change();
            $table->decimal('support_percent', 5, 2)->change();
            $table->decimal('payroll_tax_percent', 5, 2)->change();
            $table->decimal('benefits_percent', 5, 2)->change();
            $table->decimal('commission_percent', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('database', function (Blueprint $table) {
            //
        });
    }
};
