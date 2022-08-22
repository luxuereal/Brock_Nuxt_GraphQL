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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('zip');
            $table->boolean('is_active');
            $table->boolean('is_vending');
            $table->date('start_period')->nullable(); // need to be clarified
            $table->string('payroll_password')->nullable(); // need to be clarified
            // TODO: add foreign keys
            $table->integer('district_id');
            $table->integer('county_id');
            $table->integer('city_id');
            $table->decimal('management_percent', 4, 2)->nullable();
            $table->decimal('management_amount', 8, 2)->nullable();
            $table->string('management_fee_type')->nullable();
            $table->decimal('administrative_percent', 4, 2)->nullable();
            $table->decimal('administrative_amount', 8, 2)->nullable();
            $table->string('administrative_fee_type')->nullable();
            $table->decimal('support_percent', 4, 2)->nullable();
            $table->decimal('support_amount', 8, 2)->nullable();
            $table->string('support_fee_type')->nullable();
            $table->decimal('payroll_tax_percent', 4, 2)->nullable();
            $table->decimal('benefits_percent', 4, 2)->nullable();
            $table->decimal('benefits_amount', 8, 2)->nullable();
            $table->decimal('vacation_amount', 8, 2)->nullable();
            $table->decimal('business_insurance_amount', 8, 2)->nullable();
            $table->decimal('vending_income', 8, 2)->nullable();
            $table->decimal('commission_amount', 8, 2)->nullable();
            $table->decimal('commission_percent', 4, 2)->nullable();
            $table->string('manager_first_name')->nullable();
            $table->string('manager_last_name')->nullable();
            $table->integer('population')->nullable();
            $table->boolean('is_kronos')->nullable();
            $table->string('sysco')->nullable();
            // $table->string('reg_tax_gl')->nullable(); // need to be clarified
            // $table->string('reg_tax_gl_sub')->nullable(); // need to be clarified
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
        Schema::dropIfExists('units');
    }
};
