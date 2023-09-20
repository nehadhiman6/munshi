<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevPurchaserSolicitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchser_solicitors', function (Blueprint $table) {
            if (Schema::hasColumn('purchser_solicitors', 'law_clerk_name') == false) {
                $table->string('law_clerk_name',500)->nullable()->after('law_Clerk_id');
            }
        });
        Schema::table('purchser_solicitors', function (Blueprint $table) {
            if (Schema::hasColumn('purchser_solicitors', 'law_firm_name') == true) {
                $table->dropColumn(['law_firm_name']);
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
