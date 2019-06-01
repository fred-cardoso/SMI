@extends('layout.layout')
@section('title', __('categorias.edit_cat'))
@section('content')
    <section class="content-header">
        <h1>
            @lang("categorias.categories")
            <small>@lang("categorias.edit_cat") : {{$categoria->nome}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route('categorias')}}"><i class="fa fa-book"></i>@lang("categorias.categories")</a></li>
            <li class="active"><i class="fa fa-pencil"></i> @lang("categorias.edit_cat")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layout.result')
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
                                <label for="nomeCat">@lang("categorias.name_cat")</label>
                                <input type="text" class="form-control" name="nomeCat" id="nomeCat"
                                       value="{{$categoria->nome}}">
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        @role('admin')
                                        <input type="checkbox" name="secundaria">@lang("categorias.secondary")
                                        @else
                                            <input type="checkbox" name="secundaria" checked
                                                   disabled>@lang("categorias.secondary")
                                            @endrole
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit"
                                    class="btn btn-primary pull-right">@lang("categorias.edit_cat")</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box-body -->
            </div>
            </form>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection