@extends('layout.layout')
@section('title', 'Upload')
@section('content')
    <section class="content-header">
        <h1>
            Utilizadores
            <small>Criar Utilizador</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li><a href="{{route("users")}}"><i class="fa fa-users"></i> Utilizadores</a></li>
            <li class="active">Criar Utilizador</li>
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
                <form role="form" action="{{route('users.create')}}" method="POST">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Criar Utilizador</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}" required>
                            </div>
                            <div class="form-group">
                                <label>Grupo</label>
                                <select name="group" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{$category->name}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label>Confirmar Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       value="{{old('password_confirmation')}}" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Criar</button>
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        Título:
        <input type="text" name="title" value="{{$conteudo->titulo ?? ''}}"></br>
        Descrição:
        <textarea name="description">{{$conteudo->descricao ?? ''}}</textarea></br>
        Privado:
        <input type="checkbox" name="private"></br>
        Categoria:
        <select name="category"></br>
            @foreach($categories as $category)

                <?php if (isset($conteudo)) {
                    $selected = $conteudo->hasCategory($category);
                } else {
                    $selected = false;
                } ?>

                <option value="{{$category->id}}" @if($selected) selected @endif> {{$category->nome}}</option>
            @endforeach
        </select></br>
        Tags (separadas por vírgulas):
        <input type="text" name="tags"></br>
        @if(!isset($conteudo))
            <input type="file" name="file"></br>
        @endif
        <input type="submit" value="@isset($conteudo)Editar Conteúdo @else Upload @endisset" name="submit"></br>
    </form>
@endsection