<?php
namespace App\Permissions;

use App\Permissions;
use App\Role;

trait HasPermissionsTrait{
    public function roles() {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function hasRole( ... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }
}