<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->after('password')->index();
            $table->integer('company_profile_id')->unsigned()->nullable()->after('role_id');
            $table->integer('profile_id')->unsigned()->nullable()->after('company_profile_id');
            $table->string('ruby')->nullable()->after('name');
            $table->string('birthday')->nullable()->after('profile_id');
            $table->string('phone')->nullable()->after('birthday');
            $table->string('zip')->nullable()->after('phone');
            $table->string('address')->nullable()->after('zip');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('company_profile_id')->references('id')->on('company_profiles');
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('company_profile_id');
            $table->dropColumn('profile_id');
            $table->dropColumn('ruby');
            $table->dropColumn('birthday');
            $table->dropColumn('phone');
            $table->dropColumn('zip');
            $table->dropColumn('address');
        });
    }
}
