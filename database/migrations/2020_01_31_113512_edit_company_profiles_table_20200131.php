<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCompanyProfilesTable20200131 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('company_ruby');
            $table->string('area_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('company_variation')->nullable();
            $table->string('public_or_private')->nullable();
            $table->string('fax')->nullable();
            $table->string('kyokai_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->string('company_name');
            $table->string('company_ruby');
            $table->dropColumn('area_name');
            $table->dropColumn('branch_name');
            $table->dropColumn('company_variation');
            $table->dropColumn('public_or_private');
            $table->dropColumn('fax');
            $table->dropColumn('kyokai_number');
        });
    }
}
