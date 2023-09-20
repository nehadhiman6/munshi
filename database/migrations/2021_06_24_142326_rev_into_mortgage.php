<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RevIntoMortgage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'contact_id') == true) {
                $table->string('contact_id')->nullable()->change();
            }
        });

        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'contact_id') == true) {
                $table->renameColumn('contact_id', 'contact');
            }
        });

        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'mortgagee') == true) {
                $table->integer('mortgagee')->nullable()->change();
            }
        });

        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'mortgagee') == true) {
                $table->renameColumn('mortgagee', 'mortgagee_id');
            }
        });

        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'discharged_on') == false) {
                $table->date('discharged_on')->after('total_mortgage_payable_discharge')->nullable();
            }
        });

        Schema::table('mortgagees', function (Blueprint $table) {
            if (Schema::hasColumn('mortgagees', 'extra_interest') == false) {
                $table->decimal('extra_interest', 12, 2)->after('discharged_on')->nullable();
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
