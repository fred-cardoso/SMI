@extends('layout.layout')
@section('title', 'Upload')
@section('content')
    <section class="content-header">
        <h1>
            @lang("conteudos.content")
            <small>Upload</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-television"></i>@lang("conteudos.content")</a></li>
            <li class="active"><i class="fa fa-upload"></i> @lang("conteudos.upload")</li>
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
                <div class="alert alert-info">
                    <h4>@lang("common.info")</h4>
                    <p>@lang("conteudos.msg1")<i>@lang("conteudos.meta")</i>.@lang("conteudos.msg2") <i>@lang("conteudos.meta")</i> @lang("conteudos.msg3")<a target="_blank" href="{{Storage::url('public/zip_files.xsd')}}">XSD</a>.</p>
                    <p>@lang("conteudos.msg4")<i>@lang("conteudos.meta")</i> @lang("conteudos.msg5")</p>
                </div>
                <form role="form" action="{{route('upload')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang("conteudos.content_new")</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>@lang('conteudos.title')</label>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('conteudos.description')</label>
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('categorias.categories')</label>
                                @foreach($categories as $category)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]"
                                                   value="{{$category->id}}" {{in_array($category->id, old('category') ?? []) ? 'checked' : ''}}>{{$category->nome}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form_group">
                                <label>@lang("conteudos.content_privacy")</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="private"
                                               value="on" {{old('private') ?? ''}}/>@lang('conteudos.private_content')
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>@lang('common.file')</label>
                                <input type="file" name="file" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">@lang("common.send")</button>
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