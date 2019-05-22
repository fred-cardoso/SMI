<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_user', function (Blueprint $table) {
            $table->integer("subscriberID")->unsigned();
            $table->integer("subscribedID")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            //$table->foreign('subscriberID')->references('id')->on('user')->onDelete('cascade');
            //$table->foreign('subscribedID')->references('id')->on('user')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['subscriberID','subscribedID']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_user');
    }
}
