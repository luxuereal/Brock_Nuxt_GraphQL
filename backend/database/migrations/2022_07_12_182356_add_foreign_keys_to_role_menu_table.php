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
        Schema::table('role_menus', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->change();
            $table->foreign('role_id')->references('id')->on('roles')->nullOnDelete();
            $table->unsignedBigInteger('menu_id')->nullable()->change();
            $table->foreign('menu_id')->references('id')->on('menus')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_menus', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['menu_id']);
        });
    }
};
