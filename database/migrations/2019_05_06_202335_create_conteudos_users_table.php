<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudosUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos_users', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer('userID');
            $table->integer('conteudoID');
            $table->date('dataPub');
            $table->boolean("privado");
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
           // $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('conteudoID')->references('id')->on('conteudos')->onDelete('cascade');


            //SETTING THE PRIMARY KEYS
            //$table->primary(['userID,conteudoID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos_users');
    }
}
