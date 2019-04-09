<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('sent_to_id')->unsigned();
            $table->text('body');
            $table->text('subject');
            $table->date('date');
            $table->timestamps();
        });

        Schema::table('messages', function($table) {
          $table->foreign('sender_id')
                  ->references('id')
                  ->on('residents')->onDelete('cascade');
        });

        Schema::table('messages', function($table) {
          $table->foreign('sent_to_id')
                  ->references('id')
                  ->on('residents')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
