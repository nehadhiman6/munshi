<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_statements', function (Blueprint $table) {
            $table->id();
            $table->integer('file_opening_id')->nullable();
            $table->decimal('total_fees', 12, 2)->nullable();
            $table->decimal('hst', 12, 2)->nullable();
            $table->string('hst_disbursement_total')->nullable();
            $table->decimal('hst_disbursement_hst', 12, 2)->nullable();
            $table->decimal('non_hst_disbursement_total', 12, 2)->nullable();
            $table->decimal('total_fees_disbursement', 12, 2)->nullable();
            $table->decimal('total_hst', 12, 2)->nullable();
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
