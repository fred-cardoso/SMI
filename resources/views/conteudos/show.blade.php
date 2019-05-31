@extends('layout.layout')
@section('title', $conteudo->titulo)
@section('content')
    <section class="content-header">
        <h1>
            {{$conteudo->titulo}}
            <small>@lang('conteudos.list_content')</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>@lang('categorias.home_page')</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-television"></i> @lang('conteudos.content')</a></li>
            <li class="active"><i class="fa fa-youtube-square"></i> {{$conteudo->titulo}}</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{$conteudo->titulo}}</h3>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i>@lang('conteudos.description')</strong>
                        <p class="text-muted">{{$conteudo->descricao}}</p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('common.author')</strong>
                        <p class="text-muted"><a
                                    href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                        </p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('common.visibility')</strong>
                        <p class="text-muted"><span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? 'Privado' : 'Público'}}</span></p>
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> @lang('categorias.categories')</strong>
                        <p>
                            @foreach($conteudo->category()->get() as $categoria)
                                <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                            @endforeach

                        </p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> @lang('common.creation_date')</strong>
                        <p>{{$conteudo->created_at}}</p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i>@lang('common.last_modified')</strong>
                        <p>{{$conteudo->updated_at}}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
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
        </div>
    </section>
@endsection