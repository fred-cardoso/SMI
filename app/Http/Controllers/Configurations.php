<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Configurations extends Controller
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
        setEnv('mail_driver','abc');
        dd($request->mail_host);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conteudo  $conteudo
     * @return \Illuminate\Http\Response
     */
}