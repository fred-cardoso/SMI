<?php

use Illuminate\Database\Seeder;
//use GruposSeeder,PermissionTableSeeder,RoleTableSeeder,UserTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GruposSeeder::class);
        //$this->call(UserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);


    }
}
