<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RvIntoAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'street') == true && Schema::hasColumn('addresses', 'number') == false) {
                $table->renameColumn('street', 'number');
            }
        });

        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'continued') == true) {
                $table->renameColumn('continued', 'street');
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
