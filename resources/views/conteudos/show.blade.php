<?php

use Illuminate\Support\Facades\Storage;

?>
@extends('layout.layout')
@section('title', $conteudo->titulo)
@section('content')
    <section class="content-header">
        <h1>
            {{$conteudo->titulo}}
            <small>Lista de Conteúdos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li><a href="{{route('uploads')}}">Conteúdos</a></li>
            <li class="active">{{$conteudo->titulo}}</li>
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
                        <strong><i class="fa fa-book margin-r-5"></i> Descrição</strong>
                        <p class="text-muted">{{$conteudo->descricao}}</p>
                        <hr>
                        <strong><i class="fa fa-map-marker margin-r-5"></i> Autor</strong>
                        <p class="text-muted"><a
                                    href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                        </p>
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> Categorias</strong>
                        <p>
                            @foreach($conteudo->category()->get() as $categoria)
                                <span class="label label-{{$categoria->secundaria == 1 ? 'info' : 'primary'}}">{{$categoria->nome}}</span>
                            @endforeach

                        </p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Data da Criação</strong>
                        <p>{{$conteudo->created_at}}</p>
                        <hr>
                        <strong><i class="fa fa-file-text-o margin-r-5"></i> Última Modificação</strong>
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