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
            @if($conteudo->tipo == 'audio')
                <li><a href="{{route('uploads')}}"><i class="fa fa-music"></i> {{$conteudo->titulo}}</a></li>
            @elseif($conteudo->tipo == 'video')
                <li><a href="{{route('uploads')}}"><i class="fa fa-youtube"></i> {{$conteudo->titulo}}</a></li>
            @else
                <li><a href="{{route('uploads')}}"><i class="fa fa-image"></i> {{$conteudo->titulo}} </a></li>
            @endif
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
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
                        @auth
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> @lang('common.visibility')</strong>
                            <p style="margin-top: 5px;">
                                <span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? 'Privado' : 'Público'}}</span>
                            </p>
                        @endauth
                        <hr>
                        <strong><i class="fa fa-pencil margin-r-5"></i> @lang('categorias.categories')</strong>
                        <p style="margin-top: 5px;">
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
                        @if(auth()->check() and (auth()->user()->hasRole('admin') or $conteudo->isOwner(auth()->user())))
                            <hr>
                            <strong><i class="fa fa-pencil margin-r-5"></i> @lang('common.actions')</strong>
                            <p><a href="{{route('uploads.edit', $conteudo->id)}}" type="button"
                                  class="btn btn-primary">@lang('common.edit')</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#modal-delete-content-{{$conteudo->id}}"
                                        wfd-id="264">
                                    @lang('common.delete')
                                </button>
                            </p>
                        @endif
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
        </div>
    </section>
@endsection
<div class="modal modal-danger fade" id="modal-delete-content-{{$conteudo->id}}" wfd-id="130">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">@lang('common.warning')</h4>
            </div>
            <div class="modal-body">
                <p>@lang('conteudos.perm_delete') <b>{{$conteudo->titulo}}</b> ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                    @lang('categorias.cancel')
                </button>
                <form action="{{route('uploads.delete', $conteudo->id)}}" method="POST">
                    @csrf
                    <input type="submit" class="btn btn-outline" wfd-id="250"
                           value="@lang("conteudos.delete_content")">
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>