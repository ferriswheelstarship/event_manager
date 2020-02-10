<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditProfilesTable20200206 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('serial_number');
            $table->string('childminder_status')->nullable();
            $table->string('childminder_number')->nullable();
            $table->string('other_facility_name')->nullable();
            $table->string('other_facility_zip')->nullable();
            $table->string('other_facility_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('serial_number')->nullable();
            $table->dropColumn('childminder_status');
            $table->dropColumn('childminder_number');
            $table->dropColumn('other_facility_name');
            $table->dropColumn('other_facility_zip');
            $table->dropColumn('other_facility_address');
        });
    }
}
