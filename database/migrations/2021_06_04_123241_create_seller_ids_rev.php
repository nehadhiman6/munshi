<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerIdsRev extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sellers_ids');
        Schema::create('sellers_ids', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id')->nullable();
            $table->string('id_type')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('number')->nullable();
            $table->string('issuing_jurisdiction')->nullable();
            $table->string('issuing_country')->nullable();
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
        Schema::dropIfExists('seller_ids_rev');
    }
}
