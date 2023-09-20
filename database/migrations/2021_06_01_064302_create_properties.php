<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->integer('lro')->nullable();
            $table->string('street_no')->nullable();
            $table->string('unit_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('roll_no')->nullable();
            $table->char('survey_available',1)->nullable();
            $table->integer('surveyor_id')->nullable();
            $table->date('date')->nullable();
            $table->char('title_search_performed',1)->nullable();
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
        Schema::dropIfExists('properties');
    }
}
