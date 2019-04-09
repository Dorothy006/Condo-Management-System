
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('roomId')->unsigned();
            $table->string('packageName')->nullable();
            $table->string('packageInfo')->nullable();
            $table->integer('mailboxId')->unsigned();
            $table->integer('mailboxPW');
            $table->date('date');
            $table->boolean('status')->default(1);
            $table->timestamps();



        });

        Schema::table('packages', function($table) {
          $table->foreign('roomId')->references('id')->on('rooms')->onDelete('cascade');
        });

        Schema::table('packages', function($table) {
          $table->foreign('mailboxId')->references('id')->on('mailboxes')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
