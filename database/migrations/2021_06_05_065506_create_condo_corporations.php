<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCondoCorporations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condo_corporations', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->string('condo_corporation_name')->nullable();
            $table->string('type')->nullable();
            $table->string('management_company')->nullable();
            $table->string('management_address',1000)->nullable();
            $table->string('attention')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->decimal('status_certificate_fees', 12, 2)->nullable();
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
        Schema::dropIfExists('condo_corporations');
    }
}
