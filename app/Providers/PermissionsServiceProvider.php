<?php

namespace App\Providers;

use App\Role;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Permission;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Permission::get()->map(function ($permission) {
            Gate::define($permission->slug, function ($user) use ($permission) {
                return $user->hasPermissionTo($permission);
            });
        });
        //Blade directives
        Blade::directive('role', function ($role) {
            $role = str_replace("'", "", $role);

            $roleBD = Role::where('slug', $role)->first();

            $value = "false";

            if (auth()->check()) {
                try {
                    if ($roleBD->id >= auth()->user()->roles()->first()->id) {
                        $value = "true";
                    }
                } catch (\Exception $exception) {
                    //Catch unrecognized $role variable
                }
            }

            return "<?php if(auth()->check() && {$value}) { ?>";
        });
        Blade::directive('endrole', function () {
            return "<?php } ?>";
        });
    }
}
