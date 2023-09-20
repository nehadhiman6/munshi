<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersIds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers_ids', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address',2000)->nullable();
            $table->string('phone_no')->nullable();
            $table->string('occupation')->nullable();
            $table->string('email')->nullable();
            $table->string('business_name',500)->nullable();
            $table->string('business_address',2000)->nullable();
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
        Schema::dropIfExists('sellers_ids');
    }
}
