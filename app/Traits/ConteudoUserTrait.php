<?php


namespace App\Traits;

use App\User;

trait ConteudoUserTrait
{
    public function user(){
        return $this->belongsTo("\App\User");
    }

    public function isOwner(User $user) {
        if($this->user()->first()->id == $user->id) {
            return true;
        }
        return false;
    }
}