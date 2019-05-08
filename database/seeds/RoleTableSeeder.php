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

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Administrador';
        $admin_role->save();
        $admin_role->permissions()->attach($settings_permission);
        $admin_role->permissions()->attach($manage_categories_permission);
        $admin_role->permissions()->attach($manage_users_permission);
        $admin_role->permissions()->attach($create_categories_permission);
        $admin_role->permissions()->attach($edit_content_meta_permission);
        $admin_role->permissions()->attach($download_content_permission);
        $admin_role->permissions()->attach($create_content_permission);
        $admin_role->permissions()->attach($subscribe_permission);

        $simpatizante_role = new Role();
        $simpatizante_role->slug = 'simpatizante';
        $simpatizante_role->name = 'Simpatizante';
        $simpatizante_role->save();
        $simpatizante_role->permissions()->attach($create_categories_permission);
        $simpatizante_role->permissions()->attach($edit_content_meta_permission);
        $simpatizante_role->permissions()->attach($download_content_permission);
        $simpatizante_role->permissions()->attach($create_content_permission);
        $simpatizante_role->permissions()->attach($subscribe_permission);

        $user_role = new Role();
        $user_role->slug = 'user';
        $user_role->name = 'utilizador';
        $user_role->save();
        $user_role->permissions()->attach($subscribe_permission);
    }
}
