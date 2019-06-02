<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Administrador';
        $admin_role->save();

        $simpatizante_role = new Role();
        $simpatizante_role->slug = 'simpatizante';
        $simpatizante_role->name = 'Simpatizante';
        $simpatizante_role->save();

        $user_role = new Role();
        $user_role->slug = 'user';
        $user_role->name = 'Utilizador';
        $user_role->save();
    }
}
