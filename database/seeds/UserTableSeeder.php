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
        $simp = Role::where('slug','simpatizante')->first();
        $user = Role::where('slug', 'user')->first();

        $admin = new User();
        $admin->name = 'José António';
        $admin->email = 'jantonio@exemplo.com';
        $admin->password = bcrypt('secret');
        $admin->email_verified_at = Carbon::now();
        $admin->save();
        $admin->roles()->attach($simp);


        $utilizador = new User();
        $utilizador->name = 'João Miguel';
        $utilizador->email = 'jm@email.com';
        $utilizador->password = bcrypt('secret');
        $utilizador->email_verified_at = Carbon::now();
        $utilizador->save();
        $utilizador->roles()->attach($user);
    }
}
