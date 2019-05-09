<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('slug','admin')->first();
        $user = Role::where('slug', 'user')->first();

        $admin = new User();
        $admin->name = 'Frederico Cardoso';
        $admin->email = 'fredecardoso@fakemail.com';
        $admin->password = bcrypt('secret');
        $admin->email_verified_at = Carbon::now();
        $admin->save();
        $admin->roles()->attach($admin);


        $utilizador = new User();
        $utilizador->name = 'Frederico Cardoso';
        $utilizador->email = 'fredecardoso@wishmail.com';
        $utilizador->password = bcrypt('secret');
        $utilizador->email_verified_at = Carbon::now();
        $utilizador->save();
        $utilizador->roles()->attach($user);
    }
}
