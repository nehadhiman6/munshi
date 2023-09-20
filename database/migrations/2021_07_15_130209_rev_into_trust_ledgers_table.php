<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoTrustLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'order_no') == false) {
                $table->integer('order_no')->nullable()->after('id');
            }
        });
        Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'fix_var') == false) {
                $table->char('fix_var',1)->nullable()->after('amount');
            }
        });
        Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'target_type') == false) {
                $table->string('target_type')->nullable()->after('fix_var');
            }
        });
        Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'target_field') == false) {
                $table->string('target_field')->nullable()->after('target_type');
            }
        });
        Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'target_id') == false) {
                $table->integer('target_id')->nullable()->after('target_field');
            }
        });
        Schema::table('trust_ledgers', function (Blueprint $table) {
            if (Schema::hasColumn('trust_ledgers', 'custom') == false) {
                 $table->char('custom',1)->default('N')->after('target_id');
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
