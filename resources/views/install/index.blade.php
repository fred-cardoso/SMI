<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@extends('layout.head')
@section('title', 'Instalação')
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('home')}}"><b>Media</b>SHARE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Instalação</p>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Atenção!</h4>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <hr>
        @endif
        <h4 class="text-center">Verificação de requisitos</h4>
        <hr>

        <div class="form-group has-feedback">
            <label>Versão do PHP >= 7.1.3</label>
            <i class="icon fa fa-{{$requirements['php_version'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['php_version'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão BCMath</label>
            <i class="icon fa fa-{{$requirements['bc_math'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['bc_math'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão CType</label>
            <i class="icon fa fa-{{$requirements['c_type'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['c_type'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão JSON</label>
            <i class="icon fa fa-{{$requirements['json'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['json'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão MBString</label>
            <i class="icon fa fa-{{$requirements['mb_string'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['mb_string'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão OpenSSL</label>
            <i class="icon fa fa-{{$requirements['open_ssl'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['open_ssl'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão PDO</label>
            <i class="icon fa fa-{{$requirements['pdo'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['pdo'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão Tokenizer</label>
            <i class="icon fa fa-{{$requirements['tokenizer'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['tokenizer'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Extensão XML</label>
            <i class="icon fa fa-{{$requirements['xml'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['xml'] ? 'forestgreen' : 'red'}}"></i>
        </div>

        <hr>

        <div class="form-group has-feedback">
            <label>Escrita em 'storage'</label>
            <i class="icon fa fa-{{$permissions['storage'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Escrita em 'storage/app'</label>
            <i class="icon fa fa-{{$permissions['storage_app'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_app'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Escrita em 'storage/logs'</label>
            <i class="icon fa fa-{{$permissions['storage_logs'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_logs'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>Escrita em 'storage/framework'</label>
            <i class="icon fa fa-{{$permissions['storage_framework'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_framework'] ? 'forestgreen' : 'red'}}"></i>
        </div>

        <hr>

        <form action="{{route('install')}}" method="post">
            @csrf

            <div class="form-group has-feedback">
                <input type="text" name="app_url" class="form-control" placeholder="Endereço da Aplicação (http://nome.com)" value="{{old('app_url')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>

            <h4 class="text-center">Configuração da Base de Dados</h4>
            <hr>

            <div class="form-group">
                <select name="db_connection" class="form-control">
                    <option value="mysql">MySQL</option>
                    <option value="posrtgresql">PostreSQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="sqlserver">SQL Server</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_host" class="form-control" placeholder="Endereço do Servidor" value="{{old('db_host')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_port" class="form-control" placeholder="Porto do Servidor" value="{{old('db_port')}}" required>
                <span class="fa fa-chain form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_database" class="form-control" placeholder="Nome da Base de Dados" value="{{old('db_database')}}" required>
                <span class="fa fa-database form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_username" class="form-control" placeholder="Utilizador SQL" value="{{old('db_username')}}" required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="db_password" class="form-control" placeholder="Password SQL" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>

            <h4 class="text-center">Configuração do Email</h4>
            <hr>

            <div class="form-group">
                <select name="mail_driver" class="form-control" readonly>
                    <option value="smtp">SMTP</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_host" class="form-control" placeholder="Endereço do Servidor" value="{{old('mail_host')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_port" class="form-control" placeholder="Porto do Servidor" value="{{old('mail_port')}}" required>
                <span class="fa fa-chain form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_username" class="form-control" placeholder="Utilizador SMTP" value="{{old('mail_username')}}" required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="mail_password" class="form-control" placeholder="Password SMTP" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <select name="mail_encryption" class="form-control">
                    <option value="ssl">SSL</option>
                    <option value="tls">TLS</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_from_address" class="form-control"
                       placeholder="Email Remetente (email@website.com)" value="{{old('mail_from_address')}}">
                <span class="fa fa-at form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat">Concluir
                    </button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{URL::to('/')}}/plugins/iCheck/icheck.min.js"></script>
</body>
</html>