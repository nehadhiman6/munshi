<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoFileOpening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_openings', function (Blueprint $table) {
            if (Schema::hasColumn('file_openings', 'client_id') == true) {
                $table->string('client_id')->change()->nullable();
            }
        });

        Schema::table('file_openings', function (Blueprint $table) {
            if (Schema::hasColumn('file_openings', 'client_id') == true) {
                $table->renameColumn('client_id','client_name');
            }
        });

        Schema::table('file_openings', function (Blueprint $table) {
            if (Schema::hasColumn('file_openings', 'record_no') == false) {
                $table->string('record_no')->after('file_no')->nullable();
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
