<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsers2020011402 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('birthday');
          $table->integer('birth_year')->nullable();
          $table->integer('birth_month')->nullable();
          $table->integer('birth_day')->nullable();            
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
          $table->string('birthday')->nullable()->after('profile_id');
          $table->dropColumn('birth_year');
          $table->dropColumn('birth_month');
          $table->dropColumn('birth_day');            
        });
    }
}
