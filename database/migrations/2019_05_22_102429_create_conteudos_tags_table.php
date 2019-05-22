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
            $table->integer("conteudoID")->unsigned();
            $table->integer("tagID")->unsigned();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('conteudoID')->references('id')->on('conteudos')->onDelete('cascade');
            $table->foreign('tagID')->references('id')->on('tags')->onDelete('cascade');


            //SETTING THE PRIMARY KEYS
            $table->primary(['conteudoID','tagID']);
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
