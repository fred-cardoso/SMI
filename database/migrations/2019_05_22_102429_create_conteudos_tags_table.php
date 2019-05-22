<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudosTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos_tags', function (Blueprint $table) {
            $table->integer("conteudo_id")->unsigned();
            $table->integer("tag_id")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('conteudo_id')->references('id')->on('conteudos')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');


            //SETTING THE PRIMARY KEYS
            $table->primary(['conteudo_id','tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos_tags');
    }
}
