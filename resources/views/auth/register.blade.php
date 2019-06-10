<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head', ['title' => __('auth.register')])
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="{{route('home')}}"><b>Media</b>SHARE</a>
    </div>

    <div class="register-box-body">
        <p class="login-box-msg">@lang("auth.register")</p>

        <form action="{{route('register')}}" method="post">
            @csrf
            @if(sizeof($errors->all()) > 0)
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->all() as $error)
                    {{$error}}</br>
                    @endforeach
                </div>
            @endif
            <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="@lang("auth.fullname")" value="{{old('name')}}"
                       required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="@lang("auth.email")" value="{{old('email')}}"
                       required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password_confirmation" class="form-control" placeholder="@lang("auth.repeate_pw")"
                       required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>

            @if(env('GOOGLE_RECAPTCHA_KEY'))
                <div class="form-group has-feedback">
                    <div class="g-recaptcha"
                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                    </div>
                </div>
            @endif
            <div class="row">
                <!-- /.col -->
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">@lang("auth.register")</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <hr>

        <a href="{{route('login')}}" class="text-center">@lang("auth.have_acc")</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- ReCaptcha -->
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>