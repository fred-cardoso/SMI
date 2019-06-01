<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class InstallController extends Controller
{
    private $valid = true;

    public function install()
    {
        $requirements = array();

        $requirements['php_version'] = version_compare(phpversion(), '7.1.3') == 1 ? true : false;
        $requirements['bc_math'] = extension_loaded('bcmath') ? true : false;
        $requirements['c_type'] = extension_loaded('ctype') ? true : false;
        $requirements['json'] = extension_loaded('json') ? true : false;
        $requirements['mb_string'] = extension_loaded('mbstring') ? true : false;
        $requirements['open_ssl'] = extension_loaded('openssl') ? true : false;
        $requirements['pdo'] = extension_loaded('pdo') ? true : false;
        $requirements['tokenizer'] = extension_loaded('tokenizer') ? true : false;
        $requirements['xml'] = extension_loaded('xml') ? true : false;

        $permissions = array();

        $permissions['storage'] = is_writable(storage_path()) ? true : false;
        $permissions['storage_app'] = is_writable(storage_path() . '\\app') ? true : false;
        $permissions['storage_logs'] = is_writable(storage_path() . '\\logs') ? true : false;
        $permissions['storage_framework'] = is_writable(storage_path() . '\\framework') ? true : false;

        if(in_array(false, $requirements)) {
            $this->valid = false;
        }

        return view('install.index', compact(['requirements', 'permissions']))->with('valid', $this->valid);
    }

    public function store(Request $request) {
        if(!$this->valid) {
            return $this->install();
        }

        Artisan::call('key:generate');

        $config_controller = new ConfigurationsController();

        $response = $config_controller->update($request);

        if(!$response->getStatusCode() == 302) {
            return redirect()->back()->withErrors('Ocorreu um erro!');
        }

        Storage::put('installed', '');

        return route('home');
    }
}
