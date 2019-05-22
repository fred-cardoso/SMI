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
            $table->integer("subscriber_id")->unsigned();
            $table->integer("subscribed_id")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            //$table->foreign('subscriberID')->references('id')->on('user')->onDelete('cascade');
            //$table->foreign('subscribedID')->references('id')->on('user')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['subscriber_id','subscribed_id']);

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
