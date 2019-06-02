<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = new Categoria();
        $categoria->nome = "Desporto";
        $categoria->secundaria ="0";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nome = "Musica";
        $categoria->secundaria ="0";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nome = "Jogos";
        $categoria->secundaria ="0";
        $categoria->save();

        $categoria = new Categoria();
        $categoria->nome = "Rock";
        $categoria->secundaria ="1";
        $categoria->save();

    }
}
