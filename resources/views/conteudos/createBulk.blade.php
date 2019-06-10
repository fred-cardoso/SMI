@extends('layout.layout')
@section('title', __("conteudos.bulk"))
@section('content')
    <section class="content-header">
        <h1>
            @lang("conteudos.content")
            <small>@lang('conteudos.bulk')</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-television"></i>@lang("conteudos.content")</a></li>
            <li class="active"><i class="fa fa-upload"></i>@lang('conteudos.bulk')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @include('layout.result')
                <div class="alert alert-info">
                    <h4>@lang("common.info")</h4>
                    <p>@lang("conteudos.msg1")<i>@lang("conteudos.meta")</i>.@lang("conteudos.msg2") <i>@lang("conteudos.meta")</i> @lang("conteudos.msg3")<a target="_blank" href="{{Storage::url('public/zip_files.xsd')}}">XSD</a>.</p>
                </div>
                <form role="form" action="{{route('upload.bulk')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang("conteudos.content_new")</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
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