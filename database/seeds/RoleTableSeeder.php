<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings_permission = Permission::where('slug','create-tasks')->first();
        $manage_categories_permission = Permission::where('slug', 'edit-users')->first();
        $manage_users_permission = Permission::where('slug', 'edit-users')->first();
        $create_categories_permission = Permission::where('slug', 'edit-users')->first();
        $edit_content_meta_permission = Permission::where('slug', 'edit-users')->first();
        $download_content_permission = Permission::where('slug', 'edit-users')->first();
        $create_content_permission = Permission::where('slug', 'edit-users')->first();
        $manage_categories_permission = Permission::where('slug', 'edit-users')->first();
        $subscribe_permission = Permission::where('slug', 'edit-users')->first();

        $dev_role = new Role();
        $dev_role->slug = 'admin';
        $dev_role->name = 'Administrador';
        $dev_role->save();
        $dev_role->permissions()->attach($dev_permission);

        $manager_role = new Role();
        $manager_role->slug = 'simpatizante';
        $manager_role->name = 'Simpatizante';
        $manager_role->save();
        $manager_role->permissions()->attach($manager_permission);

        $manager_role = new Role();
        $manager_role->slug = 'user';
        $manager_role->name = 'utilizador';
        $manager_role->save();
        $manager_role->permissions()->attach($manager_permission);
    }
}
