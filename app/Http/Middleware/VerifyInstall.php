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
        if(!File::exists(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'installed') and $request->path() !== 'install') {
            return redirect()->to('install');
        }

        if(File::exists(storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'installed') and $request->path() === 'install') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
