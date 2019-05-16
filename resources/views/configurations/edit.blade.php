@extends('layout.layout')
@section('title', 'Editar Configurações')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif

    <form action="" method="post">
        @csrf

        MAIL_DRIVER=<input type="text" name="mail_driver" value="{{$config['mail_driver'] ?? ''}}"> <br>
        MAIL_HOST=<input type="text" name="mail_host" value="{{$config['mail_host']  ?? ''}}"> <br>
        MAIL_PORT=<input type="number" name="mail_port" value="{{$config['mail_port']  ?? '' }}"> <br>
        MAIL_USERNAME=<input type="text" name="mail_username" value="{{$config['mail_username']  ?? ''}}"> <br>
        MAIL_PASSWORD=<input type="text" name="mail_password" value="{{$config['mail_password']  ?? ''}}"> <br>
        MAIL_ENCRYPTION=<input type="text" name="mail_encryption" value="{{$config['mail_encryption']  ?? ''}}"> <br>
        MAIL_FROM_ADDRESS=<input type="text" name="mail_from_address" value="{{$config['mail_from_address'] ?? ''}}"> <br>
        <br><br><br>

        DB_CONNECTION=<input type="text" name="db_connection" value="{{$config['db_connection']  ?? ''}}"> <br>
        DB_HOST=<input type="text" name="db_host" value="{{$config['db_host'] ?? ''}}"> <br>
        DB_PORT=<input type="number" name="db_port" value="{{$config['db_port'] ?? ''}}"> <br>
        DB_DATABASE=<input type="text" name="db_database" value="{{$config['db_database'] ?? ''}}"> <br>
        DB_USERNAME=<input type="text" name="db_username" value="{{$config['db_username'] ?? ''}}"> <br>
        DB_PASSWORD=<input type="text" name="db_password" value="{{$config['db_password'] ?? ''}}"> <br>

        <input type="submit" value="Submeter Alteraçoes">
    </form>


    <?php

    /*foreach ($categoria as $cat) {
        echo $cat->nome;
    }*/

    ?>
@endsection