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
            $table->bigIncrements('id');
            $table->bigIncrements('userID');
            $table->bigIncrements('conteudoID');
            $table->date('dataPub');
            $table->boolean("privado");
            $table->timestamps();
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
