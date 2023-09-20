<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchasers', function (Blueprint $table) {
            if (Schema::hasColumn('purchasers', 'salutation') == false) {
                $table->string('salutation')->after('file_opening_id')->nullable();
            }
        });

        Schema::table('purchasers', function (Blueprint $table) {
            if (Schema::hasColumn('purchasers', 'company_name') == false) {
                $table->string('company_name')->after('last_name')->nullable();
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
