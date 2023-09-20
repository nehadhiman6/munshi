<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemoteUserIdInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'remote_user_id') == false) {
                $table->integer('remote_user_id')->nullable()->after('id');
            }
        });
    }

    /**migrate
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
