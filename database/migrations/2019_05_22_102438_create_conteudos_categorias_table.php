<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudosCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos_categorias', function (Blueprint $table) {
            $table->integer("conteudoID")->unsigned();
            $table->integer("categoriaID")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('conteudoID')->references('id')->on('conteudos')->onDelete('cascade');
            $table->foreign('categoriaID')->references('id')->on('categorias')->onDelete('cascade');


            //SETTING THE PRIMARY KEYS
            $table->primary(['conteudoID','categoriaID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos_categorias');
    }
}
