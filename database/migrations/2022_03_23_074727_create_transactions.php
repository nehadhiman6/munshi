<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('liesure_id')->nullable();
            $table->string('transaction_id',500);
            $table->string('transaction_status')->nullable(); //failed //succeded
            $table->date('transaction_date')->nullable();
            $table->string('currency')->default('usd')->nullable();
            $table->decimal('amount_received', 7, 2)->default(0);
            $table->decimal('refund_amount', 7, 2)->default(0);
            $table->string('payment_type')->nullable();
            $table->string('gateway_type')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
