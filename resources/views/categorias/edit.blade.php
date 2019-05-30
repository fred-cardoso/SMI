@extends('layout.layout')
@section('title', 'Criar Categoria')
@section('content')
    <section class="content-header">
        <h1>
            @lang("categorias.categories")
            <small>@lang("categorias.edit_cat") : {{$categoria->nome}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route("users")}}"><i class="fa fa-users"></i> @lang("categorias.users")</a></li>
            <li class="active">@lang("categorias.edit_cat")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <form action="" method="post">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang("categorias.edit_cat")</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="nomeCat" class="col-sm-2 control-label">@lang("categorias.name_cat")</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nomeCat" id="nomeCat" placeholder="{{$categoria->nome}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <label>
                                            @role('admin')
                                            <input type="checkbox" name="secundaria">@lang("categorias.secondary")
                                            @else
                                                <input type="checkbox" name="secundaria" checked disabled>@lang("categorias.secondary")
                                                @endrole
                                        </label>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">@lang("categorias.cancel")</button>
                            <button type="submit" class="btn btn-info pull-right">@lang("categorias.edit_cat")</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection