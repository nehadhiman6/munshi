<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoPurcgaseSolicitor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchser_solicitors', function (Blueprint $table) {
            if (Schema::hasColumn('purchser_solicitors', 'law_firm_name') == true) {
                $table->dropColumn('law_firm_name');
            }
        });

        Schema::table('purchser_solicitors', function (Blueprint $table) {
            if (Schema::hasColumn('purchser_solicitors', 'law_firm_id') == false) {
                $table->integer('law_firm_id')->nullable();
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
