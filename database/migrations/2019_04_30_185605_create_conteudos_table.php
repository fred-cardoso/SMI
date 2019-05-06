<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("titulo");
            $table->string("tipo");
            $table->string("nome");
            $table->integer("utilizador");
            $table->integer("categoria");
            $table->integer("tag");
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            //$table->foreign('utilizador')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('categoria')->references('id')->on('categorias')->onDelete('cascade');
            //$table->foreign('tag')->references('id')->on('tags')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos');
    }
}
