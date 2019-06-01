@extends('layout.layout')
@section('title', __("common.search_rs"))
@section('content')
    <section class="content-header">
        <h1>
            @lang("conteudos.content")
            <small>@lang("conteudos.list_content")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li class="active"><i class="fa fa-television"></i> @lang("conteudos.content")</li>
        </ol>
    </section>
    <!-- Main content -->
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
                                @if($pesquisa->count()>0)
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>

                                        <tr>
                                            @auth
                                                <th style="width: 10px"></th>
                                            @endauth
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

                                        @foreach($pesquisa as $conteudo)
                                            @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
                                                @continue
                                            @endif
                                            <tr>
                                                @auth
                                                    <td><input type="checkbox" name="selected[]"
                                                               value="{{$conteudo->id}}">
                                                    </td>
                                                @endauth
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
                                            @auth
                                                <th></th>
                                            @endauth
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
                                @else
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
                                @endif
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
@endsection