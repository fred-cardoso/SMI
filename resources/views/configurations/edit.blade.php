@extends('layout.layout')
@section('title', 'Editar Configurações')
@section('content')
    <section class="content-header">
        <h1>
            Utilizadores
            <small>Criar Utilizador</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li><a href="{{route("users")}}"><i class="fa fa-users"></i> Utilizadores</a></li>
            <li class="active">Criar Utilizador</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
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
                <form role="form" action="{{route('users.create')}}" method="POST">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Criar Utilizador</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
                            </div>
                            <div class="form-group">
                                <label>Grupo</label>
                                <select name="group" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Confirmar Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       value="{{old('password_confirmation')}}" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Criar</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <form action="" method="post">
        @csrf

        MAIL_DRIVER=<input type="text" name="mail_driver" value="{{$config['mail_driver'] ?? ''}}"> <br>
        MAIL_HOST=<input type="text" name="mail_host" value="{{$config['mail_host']  ?? ''}}"> <br>
        MAIL_PORT=<input type="number" name="mail_port" value="{{$config['mail_port']  ?? '' }}"> <br>
        MAIL_USERNAME=<input type="text" name="mail_username" value="{{$config['mail_username']  ?? ''}}"> <br>
        MAIL_PASSWORD=<input type="text" name="mail_password" value="{{$config['mail_password']  ?? ''}}"> <br>
        MAIL_ENCRYPTION=<input type="text" name="mail_encryption" value="{{$config['mail_encryption']  ?? ''}}"> <br>
        MAIL_FROM_ADDRESS=<input type="text" name="mail_from_address" value="{{$config['mail_from_address'] ?? ''}}">
        <br>
        <br><br><br>

        DB_CONNECTION=<input type="text" name="db_connection" value="{{$config['db_connection']  ?? ''}}"> <br>
        DB_HOST=<input type="text" name="db_host" value="{{$config['db_host'] ?? ''}}"> <br>
        DB_PORT=<input type="number" name="db_port" value="{{$config['db_port'] ?? ''}}"> <br>
        DB_DATABASE=<input type="text" name="db_database" value="{{$config['db_database'] ?? ''}}"> <br>
        DB_USERNAME=<input type="text" name="db_username" value="{{$config['db_username'] ?? ''}}"> <br>
        DB_PASSWORD=<input type="text" name="db_password" value="{{$config['db_password'] ?? ''}}"> <br>

        <input type="submit" value="Submeter Alteraçoes">
    </form>
@endsection