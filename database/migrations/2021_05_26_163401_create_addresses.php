<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->morphs('addressable');
            $table->string('type')->nullable();
            $table->string('street',1000)->nullable();
            $table->string('continued',1000)->nullable();
            $table->integer('city_id')->nullable();
            $table->string('country',250)->nullable();
            $table->string('postal_code',250)->nullable();
            $table->string('province',250)->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
