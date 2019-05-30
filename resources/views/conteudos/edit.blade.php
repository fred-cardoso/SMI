@extends('layout.layout')
@section('title', 'Editar ' . $conteudo->titulo)
@section('content')
    <section class="content-header">
        <h1>
            Editar Conteúdos
            <small>{{$conteudo->titulo}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li><a href="{{route('uploads')}}"><i class="fa fa-users"></i> Conteúdos</a></li>
            <li class="active">Editar {{$conteudo->titulo}}</li>
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
                <form role="form" action="{{route('uploads.edit', $conteudo->id)}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Título</label>
                                <input type="text" name="title" class="form-control"
                                       value="{{old('title') ?? $conteudo->titulo}}" required>
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <textarea class="form-control"
                                          name="description">{{old('description') ?? $conteudo->descricao}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Categorias</label>
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
                                <label>Privacidade do Conteúdo</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="private"
                                               value="on" {{old('private') ?? $conteudo->privado == 1 ? 'checked' : ''}}/>Conteúdo Privado
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Atualizar</button>
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