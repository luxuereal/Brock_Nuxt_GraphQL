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
        Schema::dropIfExists('employees');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->decimal('salary_base', 8, 2);
            $table->decimal('salary_overtime', 8, 2);
            $table->string('state_tax_code');
            $table->string('local_tax_code');
            $table->boolean('is_hourly');
            $table->boolean('is_exempt');
            $table->boolean('is_prod_eligible');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }
};
