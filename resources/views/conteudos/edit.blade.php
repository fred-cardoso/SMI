@extends('layout.layout')
@section('title', __('categories.edit') . $conteudo->titulo)
@section('content')
    <section class="content-header">
        <h1>
            @lang('common.edit') @lang('conteudos.content')
            <small>{{$conteudo->titulo}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-television"></i>@lang("conteudos.content")</a></li>
            <li class="active"></li><i class="fa fa-pencil"></i> @lang("common.edit") {{$conteudo->titulo}}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layout.result')
                <form role="form" action="{{route('uploads.edit', $conteudo->id)}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('common.edit')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>@lang('conteudos.title')</label>
                                <input type="text" name="title" class="form-control"
                                       value="{{old('title') ?? $conteudo->titulo}}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('conteudos.description')</label>
                                <textarea class="form-control"
                                          name="description">{{old('description') ?? $conteudo->descricao}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang("categorias.categories")</label>
                                @foreach($categories as $category)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]"
                                                   value="{{$category->id}}" {{in_array($category->id, old('category') ?? []) ? 'checked' : $conteudo->hasCategory($category) ? 'checked' : ''}}>{{$category->nome}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form_group">
                                <label>@lang("conteudos.content_privacy")</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="private"
                                               value="on" {{old('private') ?? $conteudo->privado == 1 ? 'checked' : ''}}/>@lang("conteudos.private_content")
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">@lang("common.update")</button>
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