<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->integer('organization_id');
            $table->string('organization', 250);
            $table->string('title', 100)->nullable();
            $table->string('account_no', 10)->nullable();
            $table->string('organization_1', 250)->nullable();
            $table->string('url', 250);
            $table->string('type')->nullable();
            $table->string('organization_email')->nullable();
            $table->string('website')->nullable();
            $table->string('number')->nullable();
            $table->string('street', 1000)->nullable();
            $table->string('continued', 1000)->nullable();
            $table->string('city')->nullable();
            $table->string('country', 250)->nullable();
            $table->string('postal_code', 250)->nullable();
            $table->string('province', 250)->nullable();
            $table->string('fax')->nullable();
            $table->string('phone')->nullable();
            $table->string('hst_registration_no')->nullable();
            $table->string('law_society_no')->nullable();
            $table->integer('created_by')->default(0)->nullable();
            $table->integer('updated_by')->default(0)->nullable();
            $table->timestamps();
            $table->unique('organization');
            $table->unique(['url']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
