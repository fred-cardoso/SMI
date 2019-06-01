<?php


namespace App\Tasks;

use App\User;

class ClearUsersNotVerified
{
    public function __invoke()
    {
        $users = User::whereNull('email_verified_at')->get();
        foreach ($users as $user) {
            $user->forceDelete();
        }
    }
}