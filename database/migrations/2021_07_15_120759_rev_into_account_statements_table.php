<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoAccountStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_statements', function (Blueprint $table) {
            if (Schema::hasColumn('account_statements', 'total_fees_disbursement_without_hst') == false) {
                $table->decimal('total_fees_disbursement_without_hst', 12, 2)->nullable()->after('total_fees_disbursement');
            }
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
