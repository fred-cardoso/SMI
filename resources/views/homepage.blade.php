@extends('layout.layout')
@section('title', 'Página Inicial')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Página Inicial
            <small>Bem vindo!</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> Página Inicial</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @php
            $counter = 0;
        @endphp
        @foreach($conteudos as $conteudo)
            @if($conteudo->privado and (!auth()->check() or !auth()->user()->hasRole('admin') or !$conteudo->isOwner(auth()->user())))
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
                                            href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a></h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('common.author')</strong>
                                <p class="text-muted"><a
                                            href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                </p>
                                <strong><i class="fa fa-pencil margin-r-5"></i> @lang('categorias.categories')</strong>
                                <p>
                                    @foreach($conteudo->category()->get() as $categoria)
                                        <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                                    @endforeach

                                </p>
                                <hr>
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> @lang('common.creation_date')</strong>
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
                                            href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a></h3>
                            </div>
                            <div class="box-body">
                                <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('common.author')</strong>
                                <p class="text-muted"><a
                                            href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                </p>
                                <strong><i class="fa fa-pencil margin-r-5"></i> @lang('categorias.categories')</strong>
                                <p>
                                    @foreach($conteudo->category()->get() as $categoria)
                                        <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                                    @endforeach

                                </p>
                                <hr>
                                <strong><i class="fa fa-file-text-o margin-r-5"></i> @lang('common.creation_date')</strong>
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