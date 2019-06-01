@extends('layout.layout')
@section('title', $categoria->nome)
@section('content')
    <section class="content-header">
        <h1>
            @lang("categorias.categories")
            <small>{{$categoria->nome}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route("categorias")}}"><i class="fa fa-book"></i>@lang("categorias.categories")</a></li>
            <li class="active"><i class="fa fa-plus-circle"></i> {{$categoria->nome}}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        @if($conteudos->count() == 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('conteudos.no_content')</h3>
                        </div>
                        <div class="box-body">
                            <p class="text-muted">@lang('conteudos.no_cnt_msg'){{$categoria->nome}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @php
            $counter = 0;
        @endphp
        @foreach($conteudos as $conteudo)
                @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
                @continue
            @endif
            @php
                $counter++;
            @endphp
            <div class="row">
                @if($counter % 2 == 0)
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><a
                                            href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a>
                                </h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-user margin-r-5"></i> @lang('common.author')</strong>
                                <p class="text-muted"><a
                                            href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                </p>
                                <strong><i class="fa fa-book margin-r-5"></i> @lang('categorias.categories')</strong>
                                <p>
                                    @foreach($conteudo->category()->get() as $categoria)
                                        <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                                    @endforeach

                                </p>
                                <hr>
                                <strong><i class="fa fa-calendar margin-r-5"></i> @lang('common.creation_date')
                                </strong>
                                <p>{{$conteudo->created_at}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-body">
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
                        </div>
                    </div>
                @else
                    <div class="col-md-9">
                        <div class="box box-primary">
                            <div class="box-body">
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
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><a
                                            href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a>
                                </h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-user margin-r-5"></i> @lang('common.author')</strong>
                                <p class="text-muted"><a
                                            href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                </p>
                                <strong><i class="fa fa-book margin-r-5"></i> @lang('categorias.categories')</strong>
                                <p>
                                    @foreach($conteudo->category()->get() as $categoria)
                                        <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                                    @endforeach

                                </p>
                                <hr>
                                <strong><i class="fa fa-calendar margin-r-5"></i> @lang('common.creation_date')
                                </strong>
                                <p>{{$conteudo->created_at}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        {{$conteudos->links()}}

    </section>
    <!-- /.content -->
@endsection