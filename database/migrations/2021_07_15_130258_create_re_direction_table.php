<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReDirectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redirection_funds', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no')->nullable();
            $table->integer('file_opening_id')->nullable();
            $table->string('particulars')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->char('fix_var',1)->nullable();
            $table->string('target_type')->nullable();
            $table->string('target_field')->nullable();
            $table->integer('target_id')->nullable();
            $table->char('custom',1)->nullable()->default('N');
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
        Schema::dropIfExists('redirection_funds');
    }
}
