<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsInLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leisures', function (Blueprint $table) {
            if (Schema::hasColumn('leisures', 'vcode') == false) {
                $table->string('vcode', 10)->after('id');
            }
            if (Schema::hasColumn('leisures', 'hst_rate') == false) {
                $table->decimal('hst_rate', 7, 2)->after('organization_id')->default(0);
            }
            if (Schema::hasColumn('leisures', 'hst_amt') == false) {
                $table->decimal('hst_amt', 10, 2)->after('hst_rate')->default(0);
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
        Schema::table('ledger', function (Blueprint $table) {
            //
        });
    }
}
