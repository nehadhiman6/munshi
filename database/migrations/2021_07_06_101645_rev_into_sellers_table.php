<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'is_current_address_subject_property') == false) {
                $table->char('is_current_address_subject_property',1)->default('N')->nullable()->after('file_review_date');
            }
        });

        Schema::table('purchasers', function (Blueprint $table) {
            if (Schema::hasColumn('purchasers', 'other_title_capacity') == false) {
                $table->string('other_title_capacity',500)->nullable()->after('title_capacity');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'company_name') == false) {
                $table->string('company_name',500)->nullable()->after('last_name');
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
