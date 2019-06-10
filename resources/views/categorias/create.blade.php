@extends('layout.layout')
@section('title', __('categorias.create_cat'))
@section('content')
    <section class="content-header">
        <h2>
            @lang("categorias.categories")
            <small>@lang("categorias.create")</small>
        </h2>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route("categorias")}}"><i class="fa fa-book"></i>@lang("categorias.categories")</a></li>
            <li class="active"><i class="fa fa-plus-circle"></i> @lang("categorias.create_cat")</li>
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
                            <h3 class="box-title">@lang("categorias.create_cat")</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="nomeCat">@lang("categorias.name_cat")</label>
                                <div>
                                    <input type="text" class="form-control" name="nomeCat" id="nomeCat"
                                           placeholder="@lang("categorias.put_cat_name")">
                                </div>
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

                            <div class="box-footer">
                                <button type="submit"
                                        class="btn btn-primary pull-right">@lang("categorias.create_cat")</button>
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