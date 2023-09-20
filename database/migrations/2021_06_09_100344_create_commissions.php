<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->integer('brokerage_id')->nullable();
            $table->decimal('total_commission', 7, 2)->nullable();
            $table->decimal('gst', 7, 2)->nullable();
            $table->decimal('total_commission_after_gst', 7, 2)->nullable();
            $table->decimal('less_deposit', 7, 2)->nullable();
            $table->decimal('commission_payable', 7, 2)->nullable();
            $table->decimal('excess_deposit_to_seller', 7, 2)->nullable();
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
        Schema::dropIfExists('commissions');
    }
}
