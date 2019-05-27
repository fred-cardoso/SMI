@extends('layout.layout')
@section('title', 'Mostrar Categorias')
@section('content')

    <section class="content-header">
        <h1>
            Categorias
            <small>Lista de Categorias</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li class="active">Categorias</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categorias</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Secundária</th>
                                <th>Acções</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorias as $cat)
                                <tr>
                                    <td>{{$cat->id}}</td>
                                    <td>{{$cat->nome}}</td>
                                    <td>{{$cat->secundaria}}</td>
                                    <td>
                                        <?php $role = Auth::user()->roles->first();?>
                                        @if($role->slug == 'admin')
                                            <a href="{{route('cat_edit', $cat->id)}}" type="button"
                                               class="btn btn-primary">Editar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Secundária</th>
                                <th>Acções</th>
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
@endsection