<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('register_closeouts', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('register_id')->nullable()->change();
            $table->foreign('register_id')->references('id')->on('registers')->nullOnDelete();
            $table->dropColumn(['period_end']);
            $table->unsignedBigInteger('period_id')->after('unit_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
            $table->unsignedBigInteger('user_id')->after('period_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('register_closeout_items', function (Blueprint $table) {
            $table->unsignedBigInteger('register_closeout_id')->change();
            $table->foreign('register_closeout_id')->references('id')->on('register_closeouts')->cascadeOnDelete();
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->nullOnDelete();
        });

        Schema::table('catering_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->dropColumn(['period_end']);
            $table->unsignedBigInteger('period_id')->after('unit_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
            $table->unsignedBigInteger('user_id')->after('period_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->decimal('price')->nullable()->change();
        });

        Schema::table('catering_order_items', function (Blueprint $table) {
            $table->unsignedBigInteger('catering_order_id')->change();
            $table->foreign('catering_order_id')->references('id')->on('catering_orders')->cascadeOnDelete();
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('vendor_id')->nullable()->change();
            $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();
            $table->dropColumn(['period_end']);
            $table->unsignedBigInteger('period_id')->after('unit_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
            $table->unsignedBigInteger('user_id')->after('period_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('purchase_charges', function (Blueprint $table) {
            $table->unsignedBigInteger('purchase_id')->change();
            $table->foreign('purchase_id')->references('id')->on('purchases')->cascadeOnDelete();
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->nullOnDelete();
            $table->unsignedBigInteger('inventory_category_id')->nullable()->change();
            $table->foreign('inventory_category_id')->references('id')->on('inventory_categories')->nullOnDelete();
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->foreign('state_id')->references('id')->on('states')->nullOnDelete();
        });

        Schema::table('counties', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->change();
            $table->foreign('state_id')->references('id')->on('states')->nullOnDelete();
        });

        Schema::table('employee_unit', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->unsignedBigInteger('employee_id')->nullable()->change();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('vendor_id')->nullable()->change();
            $table->foreign('vendor_id')->references('id')->on('vendors')->nullOnDelete();
            $table->unsignedBigInteger('expense_type_id')->nullable()->change();
            $table->foreign('expense_type_id')->references('id')->on('expense_types')->nullOnDelete();
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->nullOnDelete();
            $table->unsignedBigInteger('period_id')->after('unit_id')->nullable();
            $table->foreign('period_id')->references('id')->on('periods')->nullOnDelete();
            $table->dropColumn(['period_end']);
            $table->unsignedBigInteger('user_id')->after('period_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->nullOnDelete();
        });

        Schema::table('gl_account_unit', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->cascadeOnDelete();
        });

        Schema::table('gl_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('gl_type_code_id')->nullable()->change();
            $table->foreign('gl_type_code_id')->references('id')->on('gl_type_codes')->nullOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable()->change();
            $table->foreign('parent_id')->references('id')->on('gl_accounts')->nullOnDelete();
        });

        Schema::table('inventory_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('gl_account_id')->nullable()->change();
            $table->foreign('gl_account_id')->references('id')->on('gl_accounts')->nullOnDelete();
        });

        Schema::table('registers', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->nullOnDelete();
            $table->unsignedBigInteger('register_type_id')->nullable()->change();
            $table->foreign('register_type_id')->references('id')->on('register_types')->nullOnDelete();
        });

        Schema::table('unit_user', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('unit_vendor', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_id')->nullable()->change();
            $table->foreign('unit_id')->references('id')->on('units')->cascadeOnDelete();
            $table->unsignedBigInteger('vendor_id')->nullable()->change();
            $table->foreign('vendor_id')->references('id')->on('vendors')->cascadeOnDelete();
        });

        Schema::table('units', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_type_id')->nullable()->change();
            $table->foreign('unit_type_id')->references('id')->on('unit_types')->nullOnDelete();
            $table->unsignedBigInteger('district_id')->nullable()->change();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
            $table->unsignedBigInteger('county_id')->nullable()->change();
            $table->foreign('county_id')->references('id')->on('counties')->nullOnDelete();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->unsignedBigInteger('term_id')->nullable()->change();
            $table->foreign('term_id')->references('id')->on('terms')->nullOnDelete();
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('register_closeouts', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['register_id']);
            $table->dropForeign(['period_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['period_id', 'user_id']);
            $table->date('period_end')->nullable();
        });

        Schema::table('register_closeout_items', function (Blueprint $table) {
            $table->dropForeign(['register_closeout_id']);
            $table->dropForeign(['gl_account_id']);
        });

        Schema::table('catering_orders', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['period_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['period_id', 'user_id']);
            $table->date('period_end')->nullable();
        });

        Schema::table('catering_order_items', function (Blueprint $table) {
            $table->dropForeign(['catering_order_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['period_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['vendor_id']);
            $table->dropColumn(['period_id', 'user_id']);
            $table->date('period_end')->nullable();
        });

        Schema::table('purchase_charges', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['gl_account_id']);
            $table->dropForeign(['inventory_category_id']);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
        });

        Schema::table('counties', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
        });

        Schema::table('employee_unit', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['employee_id']);
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['period_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['expense_type_id']);
            $table->dropForeign(['gl_account_id']);
            $table->dropForeign(['vendor_id']);
            $table->dropColumn(['period_id', 'user_id']);
            $table->date('period_end')->nullable();
        });

        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['gl_account_id']);;
        });

        Schema::table('gl_account_unit', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['gl_account_id']);
        });

        Schema::table('gl_accounts', function (Blueprint $table) {
            $table->dropForeign(['gl_type_code_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::table('inventory_categories', function (Blueprint $table) {
            $table->dropForeign(['gl_account_id']);
        });

        Schema::table('registers', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['register_type_id']);
        });

        Schema::table('unit_user', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('unit_vendor', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['unit_type_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['county_id']);
            $table->dropForeign(['city_id']);
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['term_id']);
        });
    }
};