<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('account_statements');
        Schema::create('account_statements', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->string('sale_price')->nullable();
            $table->decimal('deposit', 12, 2)->nullable();
            $table->string('property_tax')->nullable();
            $table->decimal('seller_credit', 12, 2)->nullable();
            $table->decimal('total_taxes', 12, 2)->nullable();
            $table->decimal('taxes_paid', 12, 2)->nullable();
            $table->decimal('seller_share', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('balance_due', 12, 2)->nullable();
            $table->string('remarks', 500)->nullable();
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
        Schema::dropIfExists('account_statements');
    }
}
