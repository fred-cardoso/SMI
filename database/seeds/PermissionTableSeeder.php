<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Admin permissions
         */
        $createTasks = new Permission();
        $createTasks->slug = 'settings';
        $createTasks->name = 'Gerir Definições';
        $createTasks->save();

        $editUsers = new Permission();
        $editUsers->slug = 'manage-categories';
        $editUsers->name = 'Gestão de Categorias';
        $editUsers->save();

        $editUsers = new Permission();
        $editUsers->slug = 'manage-users';
        $editUsers->name = 'Gestão de Utilizadores';
        $editUsers->save();

        /**
         * "Simpatizante" permissions
         */
        $editUsers = new Permission();
        $editUsers->slug = 'create-categories';
        $editUsers->name = 'Criação de Categorias (Secundárias)';
        $editUsers->save();

        $editUsers = new Permission();
        $editUsers->slug = 'edit-content-meta';
        $editUsers->name = 'Alteração da Meta Informação dos Conteúdos e Visibilidade';
        $editUsers->save();

        $editUsers = new Permission();
        $editUsers->slug = 'download-content';
        $editUsers->name = 'Obtenção de Conteúdos';
        $editUsers->save();

        $editUsers = new Permission();
        $editUsers->slug = 'create-content';
        $editUsers->name = 'Envio de Conteúdos';
        $editUsers->save();

        /**
         * User permissions
         */
        $editUsers = new Permission();
        $editUsers->slug = 'subscribe';
        $editUsers->name = 'Subscrição a novos eventos';
        $editUsers->save();
    }
}
