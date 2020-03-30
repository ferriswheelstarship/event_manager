<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned()->nullable();
            $table->integer('event_date_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('applying_user_id')->unsigned()->nullable();
            $table->integer('serial_number')->unsigned()->nullable();
            $table->enum('entry_status',['Y','YC','CW','N'])->default('N');
            $table->enum('ticket_status',['Y','N'])->default('N');
            $table->enum('attend_status',['Y','N'])->default('N');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('event_date_id')->references('id')->on('event_dates')->onDelete('cascade');

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
        Schema::dropIfExists('entries');
    }
}
