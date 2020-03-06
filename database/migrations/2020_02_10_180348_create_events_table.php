<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('general_or_carrerup',['general','carrerup'])->default('general');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('comment')->nullable();
            $table->timestamp('entry_start_date')->nullable();
            $table->timestamp('entry_end_date')->nullable();
            $table->timestamp('view_start_date')->nullable();
            $table->timestamp('view_end_date')->nullable();
            $table->integer('training_minute')->unsigned()->nullable();
            $table->integer('capacity')->unsigned()->nullable();
            $table->string('place')->nullable();
            $table->text('notice')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
