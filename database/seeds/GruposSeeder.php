<?php

use Illuminate\Database\Seeder;

class GruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupos')->insert([
            'nome' => "Administrador"
        ]);
        DB::table('grupos')->insert([
            'nome' => "Simpatizante"
        ]);
        DB::table('grupos')->insert([
            'nome' => "Utilizador"
        ]);
    }
}
