<?php
$categories = \App\Categoria::all();
?>
@extends('layout.layout')
@section('title', 'Upload')
@section('content')
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
        @if(!isset($category))
            <input type="file" name="file"></br>
        @endif
        <input type="submit" value="@isset($category)Editar Conteúdo @else Upload @endisset" name="submit"></br>
    </form>
@endsection