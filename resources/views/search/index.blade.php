@extends('layout.layout')
@section('title', __("common.search_rs"))
@section('content')
    <section class="content-header">
        <h1>
            @lang("common.search2")
            <small>@lang("common.search_rs")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li class="active"><i class="fa fa-television"></i> @lang("common.search_2")</li>
        </ol>
    </section>
    <!-- Main content -->
    @if($conteudos->count()>0)
        <section class="content">
            <div class="row">
                <div class="col-xs-12" id="main_div">
                    @include('layout.result')
                    @auth
                        <form action="{{route('uploads.batch')}}" method="POST" id="mass_action_form">
                            @csrf
                            @endauth
                            <div class="box">
                                <div class="box-body">

                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                        <h3>@lang('conteudos.content')</h3>
                                        <tr>

                                            
                                            <th>@lang('common.id')</th>
                                            <th>@lang('conteudos.title')</th>
                                            <th>@lang('common.author')</th>
                                            <th>@lang('common.creation_date')</th>
                                            @role('admin')
                                            <th>@lang('common.visibility')</th>
                                            @endrole
                                            @role('simpatizante')
                                            <th>@lang('common.actions')</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($conteudos as $conteudo)
                                            @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
                                                @continue
                                            @endif
                                            <tr>

                                                <td>{{$conteudo->id}}</td>
                                                <td>
                                                    <a href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a>
                                                </td>
                                                <td>
                                                    <a href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                                </td>
                                                <td>{{$conteudo->created_at}}</td>
                                                @role('admin')
                                                <td>
                                                    <span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? __('common.private') : __('common.public')}}</span>
                                                </td>
                                                @endrole
                                                @role('simpatizante')
                                                <td>
                                                    @role('simpatizante')
                                                    @if(auth()->user()->hasRole('simpatizante') and !$conteudo->isOwner(auth()->user()))

                                                    @else
                                                        <a href="{{route('uploads.edit', $conteudo->id)}}" type="button"
                                                           class="btn btn-primary">@lang('common.edit')</a>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                                data-target="#modal-delete-user-{{$conteudo->id}}"
                                                                wfd-id="264">
                                                            @lang('common.delete')
                                                        </button>
                                                    @endif
                                                    @endrole
                                                </td>
                                                @endrole
                                            </tr>
                                        @endforeach


                                        </tbody>
                                        <tfoot>
                                        <tr>

                                            <th>@lang('common.id')</th>
                                            <th>@lang('conteudos.title')</th>
                                            <th>@lang('common.author')</th>
                                            <th>@lang('common.creation_date')</th>
                                            @role('admin')
                                            <th>@lang('common.visibility')</th>
                                            @endrole
                                            @role('simpatizante')
                                            <th>@lang('common.actions')</th>
                                            @endrole
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                                <!-- /.box-body -->
                            </div>
                            @auth
                        </form>
                @endauth
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    @endif
    @if($categorias->count() > 0)
        <section class="content">
            <div class="row">
                <div class="col-xs-12" id="main_div">
                    @include('layout.result')
                    @auth
                        <form action="{{route('uploads.batch')}}" method="POST" id="mass_action_form">
                            @csrf
                            @endauth
                            <div class="box">
                                <div class="box-body">

                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                        <h3>@lang('categorias.categories')</h3>
                                        <tr>

                                            <th>@lang('common.id')</th>
                                            <th>@lang('common.name')</th>
                                            <th>@lang('categorias.type')</th>
                                            <th>@lang('common.creation_date')</th>
                                            @role('admin')
                                            <th>@lang('common.visibility')</th>
                                            @endrole
                                            @role('simpatizante')
                                            <th>@lang('common.actions')</th>
                                            @endrole
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categorias as $conteudo)
                                            <tr>
                                                <td>{{$conteudo->id}}</td>
                                                <td>
                                                    <a href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->nome}}</a>
                                                </td>
                                                <td>
                                                    <span class="label label-{{$conteudo->secundaria == 1 ? 'info' : 'primary'}}">{{$conteudo->secundaria == 1 ?  __('categorias.secondary') : __('categorias.main')}}</span>
                                                </td>
                                                <td>{{$conteudo->created_at}}</td>
                                                @role('simpatizante')
                                                <td>
                                                    @role('simpatizante')

                                                    <a href="{{route('cat.edit', $conteudo->id)}}" type="button"
                                                       class="btn btn-primary">@lang('common.edit')</a>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#modal-delete-user-{{$conteudo->id}}"
                                                            wfd-id="264">
                                                        @lang('common.delete')
                                                    </button>
                                                    @endrole
                                                </td>
                                                @endrole
                                            </tr>
                                        @endforeach


                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>@lang('common.id')</th>
                                            <th>@lang('common.name')</th>
                                            <th>@lang('categorias.type')</th>
                                            <th>@lang('common.creation_date')</th>
                                            @role('admin')
                                            <th>@lang('common.visibility')</th>
                                            @endrole
                                            @role('simpatizante')
                                            <th>@lang('common.actions')</th>
                                            @endrole
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            @auth
                        </form>
                @endauth
                <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    @endif

    @if($conteudos->count()== 0 && $categorias->count() ==0)
        <section class="content">
            <div class="row">
                <div class="col-xs-12" id="main_div">
                    @include('layout.result')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">@lang('conteudos.no_content')</h3>
                                </div>
                                <div class="box-body">
                                    <p class="text-muted">@lang('common.search_failed')
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection