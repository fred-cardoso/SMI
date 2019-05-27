<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        /**
         * Se o user não estiver logged in, aborta
         */
        if(is_null($request->user())){
            abort(404);
        }
        /**
         * Se o ID do role introduzido for menor que o do user necessita, aborta
         * Esta verificação permite uma hierarquia de roles, sendo o que tem menor
         * ID na BD é o admin e o menor é o user básico
         */
        $roleBD = Role::where('slug', $role)->first();
        if($roleBD->id < $request->user()->roles()->first()->id) {
            abort(404);
        }

        /*if(!$request->user()->hasRole($role)) {
            abort(404);
        }*/

        if($permission !== null && !$request->user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
