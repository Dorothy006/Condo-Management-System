<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLostFoundRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lost_found_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('topicId')->unsigned();
            $table->integer('residentId')->unsigned();
            $table->string('email')->nullable();
            $table->string('message');
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('lost_found_replies', function($table) {
          $table->foreign('residentId')->references('id')->on('residents')->onDelete('cascade');
        });

        Schema::table('lost_found_replies', function($table) {
          $table->foreign('topicId')->references('id')->on('lost_found_topics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lost_found_replies');
    }
}
