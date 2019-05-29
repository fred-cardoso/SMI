@extends('layout.layout')
@section('title', 'Upload')
@section('content')
    <section class="content-header">
        <h1>
            Conteúdos
            <small>Upload</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-users"></i> Conteúdos</a></li>
            <li class="active">Upload</li>
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
                <form role="form" action="{{route('upload')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Novo Conteúdo</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="title" class="form-control" value="{{old('title')}}" required>
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea class="form-control" name="description">{{old('description')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Categorias</label>
                                @foreach($categories as $category)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]"
                                                   value="{{$category->id}}" {{in_array($category->id, old('category') ?? []) ? 'checked' : ''}}>{{$category->nome}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label>Ficheiro(s)</label>
                                <input type="file" name="file" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Enviar</button>
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