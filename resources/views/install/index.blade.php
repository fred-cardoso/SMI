<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head', ['title' => __('common.installation')])
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('home')}}"><b>Media</b>SHARE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">@lang('common.installation')</p>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> @lang('common.warning')</h4>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <hr>
        @endif
        <h4 class="text-center">@lang('auth.verification')</h4>
        <hr>

        <div class="form-group has-feedback">
            <label>@lang('install.php_version')</label>
            <i class="icon fa fa-{{$requirements['php_version'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['php_version'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.BCMath')</label>
            <i class="icon fa fa-{{$requirements['bc_math'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['bc_math'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.CType')</label>
            <i class="icon fa fa-{{$requirements['c_type'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['c_type'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.JSON')</label>
            <i class="icon fa fa-{{$requirements['json'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['json'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.MBString')</label>
            <i class="icon fa fa-{{$requirements['mb_string'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['mb_string'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.OpenSSL')</label>
            <i class="icon fa fa-{{$requirements['open_ssl'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['open_ssl'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.PDO')</label>
            <i class="icon fa fa-{{$requirements['pdo'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['pdo'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.Tokenizer')</label>
            <i class="icon fa fa-{{$requirements['tokenizer'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['tokenizer'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.XML')</label>
            <i class="icon fa fa-{{$requirements['xml'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$requirements['xml'] ? 'forestgreen' : 'red'}}"></i>
        </div>

        <hr>

        <div class="form-group has-feedback">
            <label>@lang('install.storage')</label>
            <i class="icon fa fa-{{$permissions['storage'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.storage_app')</label>
            <i class="icon fa fa-{{$permissions['storage_app'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_app'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.storage_logs')</label>
            <i class="icon fa fa-{{$permissions['storage_logs'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_logs'] ? 'forestgreen' : 'red'}}"></i>
        </div>
        <div class="form-group has-feedback">
            <label>@lang('install.storage_framework')</label>
            <i class="icon fa fa-{{$permissions['storage_framework'] ? 'check' : 'ban'}} pull-right"
               style="color: {{$permissions['storage_framework'] ? 'forestgreen' : 'red'}}"></i>
        </div>

        <hr>

        <form action="{{route('install')}}" method="post">
            @csrf

            <div class="form-group has-feedback">
                <input type="text" name="app_url" class="form-control" placeholder="{{__('install.app_address')}}" value="{{old('app_url')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>
            <hr>
            <h4 class="text-center">@lang('common.config_system')</h4>
            <hr>

            <div class="form-group">
                <select name="db_connection" class="form-control">
                    <option value="mysql">MySQL</option>
                    <option value="pgsql">PostreSQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="sqlsrv">SQL Server</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_host" class="form-control" placeholder="{{__('install.server_address')}}" value="{{old('db_host')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_port" class="form-control" placeholder="{{__('install.server_port')}}" value="{{old('db_port')}}" required>
                <span class="fa fa-chain form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_database" class="form-control" placeholder="{{__('install.db_name')}}" value="{{old('db_database')}}" required>
                <span class="fa fa-database form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="db_username" class="form-control" placeholder="{{__('install.sql_user')}}" value="{{old('db_username')}}" required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="db_password" class="form-control" placeholder="{{__('install.sql_password')}}" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <hr>
            <h4 class="text-center">@lang('auth.email_config')</h4>
            <hr>

            <div class="form-group">
                <select name="mail_driver" class="form-control" readonly>
                    <option value="smtp">SMTP</option>
                </select>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_host" class="form-control" placeholder="{{__('install.server_address')}}" value="{{old('mail_host')}}" required>
                <span class="fa fa-server form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_port" class="form-control" placeholder="{{__('install.server_port')}}" value="{{old('mail_port')}}" required>
                <span class="fa fa-chain form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" name="mail_username" class="form-control" placeholder="{{__('install.smtp_user')}}" value="{{old('mail_username')}}" required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="mail_password" class="form-control" placeholder="{{__('install.smtp_password')}}" required>
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
                       placeholder="{{__('install.email_reme')}}" value="{{old('mail_from_address')}}">
                <span class="fa fa-at form-control-feedback"></span>
            </div>
            <hr>
            <h4 class="text-center">@lang('auth.admin_config')</h4>
            <hr>

            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="{{__('install.name')}}" value="{{old('name')}}" required>
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="{{__('install.email')}}" value="{{old('email')}}" required>
                <span class="fa fa-at form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="{{__('install.password')}}" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password_confirmation" class="form-control" placeholder="{{__('install.confirm_pass')}}" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit"
                            class="btn btn-primary btn-block btn-flat">@lang('common.conclude')
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