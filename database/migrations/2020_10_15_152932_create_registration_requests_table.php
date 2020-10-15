<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reg_email');
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('firstruby');
            $table->string('lastruby');
            $table->string('phone');
            $table->string('zip');
            $table->string('address');
            $table->integer('birth_year');
            $table->integer('birth_month');
            $table->integer('birth_day');
            $table->string('company_profile_id');
            $table->string('facility');
            $table->string('other_facility_name');
            $table->string('other_facility_pref');
            $table->string('other_facility_address');
            $table->string('job');
            $table->string('childminder_status');
            $table->string('childminder_number_pref');
            $table->string('childminder_number_only');
            $table->timestamps();
            $table->collation = 'utf8mb4_bin';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registration_requests');
    }
}
