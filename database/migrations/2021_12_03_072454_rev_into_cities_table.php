<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoCitiesTable extends Migration
{

    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
            if (Schema::hasColumn('cities', 'lro_id') == false) {
                $table->integer('lro_id')->after('country')->nullable();
            }
        });
    }

    public function down()
    {
        //
    }
}
