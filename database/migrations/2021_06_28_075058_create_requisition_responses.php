<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_responses', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->date('date')->nullable();
            $table->date('received_date')->nullable();
            $table->text('precedent')->nullable();
            $table->char('response_sent',1)->nullable();
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
        Schema::dropIfExists('requisition_responses');
    }
}
