<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_departments', function (Blueprint $table) {
            $table->id();
            $table->integer('city_id')->nullable();
            $table->string('department_type')->nullable();
            $table->string('department_name')->nullable();
            $table->string('city_municipality')->nullable();
            $table->string('service_provider_name')->nullable();
            $table->string('attention')->nullable();
            $table->string('street_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website_link', 1200)->nullable();
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
        Schema::dropIfExists('city_departments');
    }
}
