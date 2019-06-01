@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <section class="content-header">
        <h1>
            @lang('user.profile')
            <small>{{$user->name}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang('categorias.home_page')</a></li>
            <li><a href="{{route("users")}}"><i class="fa fa-users"></i>@lang('categorias.users') </a></li>
            <li class="active"><i class="fa fa-user"></i> @lang('user.profile')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="../../dist/img/user4-128x128.jpg"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{$user->name}}</h3>

                        <p class="text-muted text-center">{{$user->roles()->first()->name}}</p>

                        @auth
                            @if(!\Request::is('profile') and !\Request::is('users/' . Auth::user()->id))
                                <form action="{{route('user.subscribe', $user->id)}}" method="POST">
                                    @csrf
                                    <?php $userAuth = Auth::User()->id;
                                    $database = DB::table("user_user")->get();
                                    $checkIfSubscribed = sizeof($database->where('subscribed_id', $userAuth && 'user_id', $user->id));

                                    if ($checkIfSubscribed == 0) {
                                        echo '<input type="submit" class="btn btn-primary btn-block" value="'.__('common.follow').'">';


                                    } else {
                                        echo '<input type="submit" class="btn btn-warning btn-block" value="'.__('common.unfollow').'">';
                                    }

                                    ?>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">@lang('user.about')</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <strong><i class="fa fa-calendar margin-r-5"></i>@lang('user.registry_date')</strong>

                        <p class="text-muted">

                            {{$user->created_at}}
                        </p>

                        <hr>

                        <strong><i class="fa fa-id-card margin-r-5"></i>@lang('user.about')</strong>

                        <p class="text-muted">{{$user->roles()->first()->name}}</p>

                        <hr>

                        <strong><i class="fa fa-pencil margin-r-5"></i>@lang('user.content_sent')</strong>

                        <p class="text-muted">{{$user->contents()->count()}}</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li @if(!sizeof($errors->all()) > 0 and !session('success')) class="active" @endif><a
                                    href="#activity"
                                    data-toggle="tab">@lang('common.activity')</a>
                        </li>
                        @if(\Request::is('profile'))
                            <li @if(sizeof($errors->all()) > 0 or session('success')) class="active" @endif><a
                                        href="#settings"
                                        data-toggle="tab">@lang('common.config')</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="@if(!sizeof($errors->all()) > 0 and !session('success')) active @endif tab-pane"
                             id="activity">
                            @if($conteudos->count() == 0)
                                <div class="post">
                                    <div class="user-block">
                                        <span class="username" style="margin-left: 0">Utilizador sem conteúdos!</span>
                                    </div>
                                </div>
                                <!-- /.post -->
                            @endif
                            @foreach($conteudos as $conteudo)
                                    @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
                                    @continue
                                @endif
                            <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <a href="{{route('uploads.show', $conteudo->id)}}"><span class="username"
                                                                                                 style="margin-left: 0">{{$conteudo->titulo}}</span></a>
                                        <span class="description" style="margin-left: 0">
                                            <span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? __('common.private') : __('common.public')}}</span>
                                            &nbsp;{{$conteudo->created_at}}
                                        </span>
                                    </div>
                                    <!-- /.user-block -->
                                    <div class="row margin-bottom">
                                        <div class="col-sm-6">
                                            @if($conteudo->tipo == 'image')
                                                <img class="img-responsive pad"
                                                     src="data:image/jpeg;base64,{{base64_encode(Storage::get($conteudo->nome))}}"
                                                     alt="{{$conteudo->nome}}">
                                            @elseif($conteudo->tipo == 'video')
                                                <video class="img-responsive" controls>
                                                    <source src="{{route('media', explode('/', $conteudo->nome)[1])}}"
                                                            type="{{Storage::mimeType($conteudo->nome)}}">
                                                    Your browser does not support the video element.
                                                </video>
                                            @else
                                                <audio controls>
                                                    <source src="{{route('media', explode('/', $conteudo->nome)[1])}}"
                                                            type="{{Storage::mimeType($conteudo->nome)}}">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            @endif
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <p>
                                                {{$conteudo->descricao}}
                                            </p>
                                        </div>
                                        <!-- /.col -->
                                    </div>

                                    <ul class="list-inline">
                                        <li><a href="#" class="link-black text-sm"><i
                                                        class="fa fa-share margin-r-5"></i>
                                                Partilhar</a></li>
                                        <!--<li><a href="#" class="link-black text-sm"><i
                                                        class="fa fa-thumbs-o-up margin-r-5"></i> Like</a>
                                        </li>-->
                                    </ul>
                                </div>
                                <!-- /.post -->
                            @endforeach
                        </div>
                        <!-- /.tab-pane -->
                        @if(\Request::is('profile'))
                            <div class="@if(sizeof($errors->all()) > 0 or session('success')) active @endif tab-pane"
                                 id="settings">
                                <form action="{{route('profile_edit')}}" method="POST" class="form-horizontal">
                                    @csrf
                                    @if(sizeof($errors->all()) > 0)
                                        <div class="alert alert-danger" role="alert">
                                            @foreach($errors->all() as $error)
                                            {{$error}}</br>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="inputName"
                                               class="col-sm-2 control-label">@lang('common.name')</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" id="inputName"
                                                   placeholder="Nome" value="{{old('name') ?? $user->name}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail"
                                               class="col-sm-2 control-label">@lang('auth.email')</label>

                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="inputEmail"
                                                   placeholder="Email" value="{{old('email') ?? $user->email}}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">@lang('user.pw')</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="current_password" class="form-control"
                                                   placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">@lang('auth.pw')</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputExperience"
                                               class="col-sm-2 control-label">@lang('auth.repeate_pw')</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                   placeholder="Repita a password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Actualizar dados</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    @endif
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
@endsection