<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head')
@section('title', 'Login')
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{route('home')}}"><b>Media</b>SHARE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">@lang("auth.begin_session")</p>

        <form action="{{route('login')}}" method="post">
            @csrf
            @if(sizeof($errors->all()) > 0)
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->all() as $error)
                        {{$error}}</br>
                    @endforeach
                </div>
            @endif

            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="@lang('auth.email')" value="{{old('email')}}" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang("auth.remember_me")
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">@lang("auth.begin_session")</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center">
            <p>- OU -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> @lang("auth.log_facebook")</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> @lang("auth.log_google_plus")</a>
        </div>
        <!-- /.social-auth-links -->

        <a href="{{route('password.request')}}">@lang("auth.recover_pw")</a><br>
        <a href="{{route('register')}}" class="text-center">@lang("auth.reg_new_user")</a>

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
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
</body>
</html>