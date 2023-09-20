<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoSellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'business_name') == false) {
                $table->string('business_name')->after('email')->nullable();
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'business_address') == false) {
                $table->string('business_address',500)->after('business_name')->nullable();
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'occupation') == false) {
                $table->string('occupation')->after('business_address')->nullable();
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'id_verified_by') == false) {
                $table->string('id_verified_by')->after('occupation')->nullable();
            }
        });
        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'meeting_date') == false) {
                $table->date('meeting_date')->after('id_verified_by')->nullable();
            }
        });

        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'file_review_date') == false) {
                $table->date('file_review_date')->after('meeting_date')->nullable();
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
