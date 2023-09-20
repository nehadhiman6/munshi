<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchserSolicitors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchser_solicitors', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->integer('solicitor_id')->nullable();
            $table->string('solicitor_email')->nullable();
            $table->string('law_firm_name')->nullable();
            $table->string('law_firm_address',1000)->nullable();
            $table->integer('law_clerk_id')->nullable();
            $table->string('file_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('purchser_solicitors');
    }
}
