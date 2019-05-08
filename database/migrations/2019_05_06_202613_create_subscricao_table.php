<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscricaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_categoria', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("userID");
            $table->integer("categoriaID");

            //FOREIGN KEY CONSTRAINTS
            //$table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('categoriaID')->references('id')->on('categorias')->onDelete('cascade');


            //SETTING THE PRIMARY KEYS
            //$table->primary(['userID,categoriaID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_categoria');
    }
}
