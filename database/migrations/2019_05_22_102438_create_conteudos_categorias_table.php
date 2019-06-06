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
            $table->integer("conteudo_id")->unsigned();
            $table->integer("categoria_id")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('conteudo_id')->references('id')->on('conteudos')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['conteudo_id','categoria_id']);
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
