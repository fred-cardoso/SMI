<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head', ['title' => __('auth.begin_session')])
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

        <hr>

        <a href="{{route('password.request')}}">@lang("auth.recover_pw")</a><br>
        <a href="{{route('register')}}" class="text-center">@lang("auth.reg_new_user")</a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.1/icheck.min.js"></script>
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