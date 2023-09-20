<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolicitorIdNameInitialsToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'name_initials') == false) {
                $table->string('name_initials')->after('type')->nullable();
            }
        });
        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'default_solicitor_id') == false) {
                $table->integer('default_solicitor_id')->after('name')->nullable();
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
    }
}
