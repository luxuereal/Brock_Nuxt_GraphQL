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
        Schema::table('units', function (Blueprint $table) {
            $table->unsignedBigInteger('reg_tax_id')->nullable()->after('is_kronos');
            $table->foreign('reg_tax_id')->references('id')->on('gl_accounts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropForeign(['reg_tax_id']);
            $table->dropColumn('reg_tax_id');
        });
    }
};
