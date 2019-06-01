<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationsController extends Controller
{
    public function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)
            ));
        }
    }

    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function show(Conteudo $conteudo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $config = array();

        $config['mail_driver'] = getenv('MAIL_DRIVER');
        $config["mail_host"] = getenv("MAIL_HOST");
        $config['mail_port']=getenv("MAIL_PORT");
        $config['mail_username'] = getenv('MAIL_USERNAME');
        $config['mail_password'] =getenv('MAIL_PASSWORD');
        $config['mail_encryption'] = getenv('MAIL_ENCRYPTION');
        $config['mail_from_address'] = getenv('MAIL_FROM_ADDRESS');


        $config['db_connection'] = getenv('DB_CONNECTION');
        $config["db_host"] = getenv("DB_HOST");
        $config['db_port']=getenv("DB_PORT");
        $config['db_database'] = getenv('db_database');
        $config['db_username'] =getenv('db_username');
        $config['db_password'] = getenv('db_password');

        //dd($config["x"]);
        //dd($config);

        return view('configurations.edit', compact('config'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|string|in:smtp',
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string|in:ssl,tls',
            'mail_from_address' => 'required|string|email',

            'db_connection' => 'required|string|in:mysql,pgsql,sqlist,sqlsrv',
            'db_host' => 'required|string',
            'db_port' => 'required|numeric',
            'db_database' => 'required|string',
            'db_username' => 'required|string',
            'db_password' => 'required|string',
        ]);

        $this ->set_env("MAIL_DRIVER",$request->mail_driver);
        $this->set_env("MAIL_HOST",$request->mail_host);
        $this ->set_env('MAIL_PORT',$request->mail_port);
        $this ->set_env('MAIL_USERNAME',$request->mail_username);
        $this ->set_env('MAIL_PASSWORD',$request->mail_password);
        $this ->set_env('MAIL_ENCRYPTION',$request->mail_encryption);
        $this ->set_env('MAIL_FROM_ADDRESS',$request->mail_from_address);

        $this ->set_env('db_connection',$request->db_connection);
        $this ->set_env('db_host',$request->db_host);
        $this ->set_env('db_port',$request->db_port);
        $this ->set_env('db_database',$request->db_database);
        $this ->set_env('db_username',$request->db_username);
        $this ->set_env('db_password',$request->db_password);

        return redirect()->back()->withSucess(__('controllers.config_save'));
    }

    public function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();

        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
    function set_env(string $key, string $value, $env_path = null)
    {
        $value = preg_replace('/\s+/', '', $value); //replace special ch
        $key = strtoupper($key); //force upper for security
        $env = file_get_contents(isset($env_path) ? $env_path : base_path('.env')); //fet .env file
        $env = str_replace("$key=" . env($key), "$key=" . $value, $env); //replace value
        /** Save file eith new content */
        $env = file_put_contents(isset($env_path) ? $env_path : base_path('.env'), $env);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
}