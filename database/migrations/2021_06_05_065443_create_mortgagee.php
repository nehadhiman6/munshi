<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgagee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('mortgagees', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->string('instrument_no')->nullable();
            $table->date('instrument_date')->nullable();
            $table->string('instrument_type')->nullable();
            $table->char('obtaining_discharge',1)->nullable();
            $table->string('mortgagee_reference_number')->nullable();
            $table->string('principal_amount')->nullable();
            $table->string('per_diem')->nullable();
            $table->string('total_mortgage_payable_discharge')->nullable();
            $table->string('mortgagee')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('solicitor_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('attention')->nullable();
            $table->string('discharge_no')->nullable();
            $table->date('discharge_date')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('mortgagees');
    }
}
