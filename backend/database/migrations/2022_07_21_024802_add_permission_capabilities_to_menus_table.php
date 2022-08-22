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
            $table->boolean('has_manage_capability')->after('slug_name')->default(true);
            $table->boolean('has_create_capability')->after('slug_name')->default(true);
            $table->boolean('has_view_capability')->after('slug_name')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('has_manage_capability');
            $table->dropColumn('has_create_capability');
            $table->dropColumn('has_view_capability');
        });
    }
};
