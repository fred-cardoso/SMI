<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;

class VerifyInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(File::exists(storage_path() . '\app\\' . 'installed')) {
            return $next($request);
        }

        if($request->path() === 'install') {
            return $next($request);
        }

        return redirect()->to('install');
    }
}
