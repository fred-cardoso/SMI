@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <section class="content-header">
        <h1>
            Conteúdos
            <small>Lista de Conteúdos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li class="active">Conteúdos</li>
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
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Data da Criação</th>
                                @role('admin')
                                <th>Visibilidade</th>
                                <th>Acções</th>
                                @endrole
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($conteudos as $conteudo)
                                @if($conteudo->privado and (!auth()->user()->hasRole('admin') or !$conteudo->user()->first()->id == auth()->user()->id))
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
                                           class="btn btn-primary">Editar</a>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-delete-user-{{$conteudo->id}}" wfd-id="264">
                                            Eliminar
                                        </button>
                                    </td>
                                    @endrole
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Autor</th>
                                <th>Data da Criação</th>
                                @role('admin')
                                <th>Visibilidade</th>
                                <th>Acções</th>
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
                        <h4 class="modal-title">Alerta!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Pretende eliminar o conteúdo <b>{{$conteudo->titulo}}</b> permanentemente?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            Cancelar
                        </button>
                        <form action="{{route('uploads.delete', $conteudo->id)}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline" wfd-id="250" value="Eliminar Conteúdo"/>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection