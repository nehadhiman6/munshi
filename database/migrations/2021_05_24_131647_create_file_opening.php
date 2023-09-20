<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileOpening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_openings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('file_no')->nullable();
            $table->integer('client_id')->nullable();
            $table->date('closing_date')->nullable();
            $table->date('agreement_of_ps_date')->nullable();
            $table->date('requisition_date')->nullable();
            $table->integer('law_clerk_id')->nullable();
            $table->string('client_reference')->nullable();
            $table->integer('real_estate_agent_id')->nullable();
            $table->integer('solicitor_id')->nullable();
            $table->string('closed_file_no')->nullable();
            $table->string('box_no')->nullable();
            $table->string('special_notes',1000)->nullable();
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
        Schema::dropIfExists('file_openings');
    }
}
