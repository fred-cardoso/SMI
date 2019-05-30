@extends('layout.layout')
@section('title', 'Editar Configurações')
@section('content')
    <section class="content-header">
        <h1>
            Configurações
            <small>Configurações de Sistema</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li class="active">Configurações</li>
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
                <div class="callout callout-warning">
                    <h4>Atenção</h4>

                    <p>Alterar as configurações de base de dados pode provocar o mau funcionamento do sistema.</p>
                    <p>Confirme primeiro se os parâmetros estão certos antes de alterar.</p>
                    <p>Se ocorrer algum problema pode editar o ficheiro de configuração manual.</p>
                </div>
                <form role="form" action="{{route('config')}}" method="POST">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar Configurações</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>MAIL_DRIVER</label>
                                <input type="text" name="mail_driver" value="{{$config['mail_driver'] ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_HOST</label>
                                <input type="text" name="mail_host" value="{{$config['mail_host']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_PORT</label>
                                <input type="number" name="mail_port" value="{{$config['mail_port']  ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_USERNAME</label>
                                <input type="text" name="mail_username" value="{{$config['mail_username']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_PASSWORD</label>
                                <input type="text" name="mail_password" value="{{$config['mail_password']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_ENCRYPTION</label>
                                <input type="text" name="mail_encryption" value="{{$config['mail_encryption']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_FROM_ADDRESS</label>
                                <input type="text" name="mail_from_address" value="{{$config['mail_from_address'] ?? ''}}" required>
                            </div>
                            </br></br></br>
                            <div class="form-group">
                                <label>DB_CONNECTION</label>
                                <input type="text" name="db_connection" value="{{$config['db_connection']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_HOST</label>
                                <input type="text" name="db_host" value="{{$config['db_host'] ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_PORT</label>
                                <input type="number" name="db_port" value="{{$config['db_port'] ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_DATABSE</label>
                                <input type="text" name="db_database" value="{{$config['db_database'] ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_USERNAME</label>
                                <input type="text" name="db_username" value="{{$config['db_username'] ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_PASSWORD</label>
                                <input type="text" name="db_password" value="{{$config['db_password'] ?? ''}}" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Atualizar</button>
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
@endsection