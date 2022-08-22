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
        Schema::create('unit_periods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('period_id')->constrained('periods');

            $table->boolean('is_closed')->default(false);

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
        Schema::dropIfExists('unit_periods');
    }
};
