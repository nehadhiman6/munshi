<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeisures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leisures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->nullable();
            $table->date('trans_date')->nullable();
            $table->string('particulars')->nullable();
            $table->decimal('dr_amount',7,3)->nullable();
            $table->decimal('cr_amount',7,3)->nullable();
            $table->integer('leisure_id')->nullable();
            $table->integer('organization_id')->nullable();
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
        Schema::dropIfExists('leisures');
    }
}
