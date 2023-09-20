<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->default(0);
            $table->date('document_date')->nullable();
            $table->string('doc_type')->nullable();
            $table->string('subject',1000)->nullable();
            $table->string('remarks',2000)->nullable();
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
        Schema::dropIfExists('file_documents');
    }
}
