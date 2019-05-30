@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <section class="content-header">
        <h1>
            @lang("conteudos.content")
            <small>@lang("conteudos.list_content")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i>@lang("categorias.home_page")</a></li>
            <li class="active">  @lang("conteudos.content")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang('common.id')</th>
                                <th>@lang('conteudos.title')</th>
                                <th>@lang('common.author')</th>
                                <th>@lang('common.creation_date')</th>
                                @role('admin')
                                <th>@lang('common.visibility')</th>
                                <th>@lang('common.actions')</th>
                                @endrole
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($conteudos as $conteudo)
                                @if($conteudo->privado and !auth()->check())
                                    @continue
                                @elseif ($conteudo->private and (!auth()->user()->hasRole('admin') or !$conteudo->user()->first()->id == auth()->user()->id))
                                    @continue
                                @endif
                                <tr>
                                    <td>{{$conteudo->id}}</td>
                                    <td><a href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a>
                                    </td>
                                    <td>
                                        <a href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                    </td>
                                    <td>{{$conteudo->created_at}}</td>
                                    @role('admin')
                                    <td>
                                        <span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? 'Privado' : 'Público'}}</span>
                                    </td>
                                    <td>
                                        <a href="{{route('uploads.edit', $conteudo->id)}}" type="button"
                                           class="btn btn-primary">@lang('common.edit')</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-delete-user-{{$conteudo->id}}" wfd-id="264">
                                            @lang('common.delete')
                                        </button>
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
                                <th>@lang('common.actions')</th>
                                @endrole
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    @foreach($conteudos as $conteudo)
        <div class="modal modal-danger fade" id="modal-delete-user-{{$conteudo->id}}" wfd-id="130">
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
                            <input type="submit" class="btn btn-outline" wfd-id="250" value="@lang("conteudos.delete_content")">
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection