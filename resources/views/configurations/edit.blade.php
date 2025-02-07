@extends('layout.layout')
@section('title', __("common.config_system"))
@section('content')
    <section class="content-header">
        <h1>
            @lang("common.config")
            <small>@lang("common.config_system")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li class="active"><i class="fa fa-cog"></i> @lang("common.config")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layout.result')
                <div class="callout callout-warning">
                    <h4>@lang("common.warning")</h4>

                    <p>@lang("common.config_msg1")</p>
                    <p>@lang("common.config_msg2")</p>
                    <p>@lang("common.config_msg3")</p>
                </div>
                <form role="form" action="{{route('config')}}" method="POST">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang("common.edit_config")</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>APP_URL</label>
                                <input class="form-control" type="text" name="app_url" value="{{$config['app_url'] ?? ''}}" required>
                            </div>
                            <hr>
                            <h4>@lang('auth.email_config')</h4>
                            <hr>
                            <div class="form-group">
                                <label>MAIL_DRIVER</label>
                                <select class="form-control" name="mail_driver" readonly>
                                    <option value="smtp">SMTP</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>MAIL_HOST</label>
                                <input class="form-control" type="text" name="mail_host" value="{{$config['mail_host']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_PORT</label>
                                <input class="form-control" type="number" name="mail_port" value="{{$config['mail_port']  ?? '' }}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_USERNAME</label>
                                <input class="form-control" type="text" name="mail_username" value="{{$config['mail_username']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_PASSWORD</label>
                                <input class="form-control" type="text" name="mail_password" value="{{$config['mail_password']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_ENCRYPTION</label>
                                <input class="form-control" type="text" name="mail_encryption" value="{{$config['mail_encryption']  ?? ''}}" required>
                            </div>
                            <div class="form-group">
                                <label>MAIL_FROM_ADDRESS</label>
                                <input class="form-control" type="email" name="mail_from_address" value="{{$config['mail_from_address'] ?? ''}}" required>
                            </div>
                            <hr>
                            <h4>@lang('auth.db_config')</h4>
                            <hr>
                            <div class="form-group">
                                <label>DB_CONNECTION</label>
                                <select class="form-control" name="db_connection">
                                    <option value="mysql">MySQL</option>
                                    <option value="pgsql">PostreSQL</option>
                                    <option value="sqlite">SQLite</option>
                                    <option value="sqlsrv">SQL Server</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>DB_HOST</label>
                                <input class="form-control" type="text" name="db_host" value="{{$config['db_host']}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_PORT</label>
                                <input class="form-control" type="number" name="db_port" value="{{$config['db_port']}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_DATABSE</label>
                                <input class="form-control" type="text" name="db_database" value="{{$config['db_database']}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_USERNAME</label>
                                <input class="form-control" type="text" name="db_username" value="{{$config['db_username']}}" required>
                            </div>
                            <div class="form-group">
                                <label>DB_PASSWORD</label>
                                <input class="form-control" type="text" name="db_password" value="{{$config['db_password']}}" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">@lang("common.update")</button>
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