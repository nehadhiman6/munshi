<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoProperties extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'sale_of') == false) {
                $table->string('sale_of')->after('postal_code')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'condo_corporation') == false) {
                $table->string('condo_corporation')->after('sale_of')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'lot_part') == false) {
                $table->string('lot_part')->after('condo_corporation')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'lot') == false) {
                $table->string('lot')->after('lot_part')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'plan') == false) {
                $table->string('plan')->after('lot')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'being_part') == false) {
                $table->string('being_part')->after('plan')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'on_plan') == false) {
                $table->string('on_plan')->after('being_part')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'parcel') == false) {
                $table->string('parcel')->after('on_plan')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'section') == false) {
                $table->string('section')->after('parcel')->nullable();
            }
        });
        Schema::table('properties', function (Blueprint $table) {
            if (Schema::hasColumn('properties', 'customer_no') == false) {
                $table->string('customer_no')->after('roll_no')->nullable();
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
