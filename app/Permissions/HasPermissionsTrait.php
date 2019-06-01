<?php
namespace App\Permissions;

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

    public function hasAccess($role) {
        $role = str_replace("'", "", $role);

        try {
            if (auth()->user()->roles()->first()->id <= Role::where('slug', $role)->first()->id) {
                return true;
            }
        } catch (\Exception $exception) {
            //Catch unrecognized $role variable
        }

        return false;
    }
}