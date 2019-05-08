<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings_permission = Permission::where('slug','settings')->first();
        $manage_categories_permission = Permission::where('slug', 'manage-categories')->first();
        $manage_users_permission = Permission::where('slug', 'manage-users')->first();
        $create_categories_permission = Permission::where('slug', 'create-categories')->first();
        $edit_content_meta_permission = Permission::where('slug', 'edit-content-meta')->first();
        $download_content_permission = Permission::where('slug', 'download-content')->first();
        $create_content_permission = Permission::where('slug', 'create-content')->first();
        $subscribe_permission = Permission::where('slug', 'subscribe')->first();

        $dev_role = new Role();
        $dev_role->slug = 'admin';
        $dev_role->name = 'Administrador';
        $dev_role->save();
        $dev_role->permissions()->attach($settings_permission);
        $dev_role->permissions()->attach($manage_categories_permission);
        $dev_role->permissions()->attach($manage_users_permission);
        $dev_role->permissions()->attach($create_categories_permission);
        $dev_role->permissions()->attach($edit_content_meta_permission);
        $dev_role->permissions()->attach($download_content_permission);
        $dev_role->permissions()->attach($create_content_permission);
        $dev_role->permissions()->attach($subscribe_permission);

        $manager_role = new Role();
        $manager_role->slug = 'simpatizante';
        $manager_role->name = 'Simpatizante';
        $manager_role->save();
        $dev_role->permissions()->attach($create_categories_permission);
        $dev_role->permissions()->attach($edit_content_meta_permission);
        $dev_role->permissions()->attach($download_content_permission);
        $dev_role->permissions()->attach($create_content_permission);
        $dev_role->permissions()->attach($subscribe_permission);

        $manager_role = new Role();
        $manager_role->slug = 'user';
        $manager_role->name = 'utilizador';
        $manager_role->save();
        $dev_role->permissions()->attach($subscribe_permission);
    }
}
