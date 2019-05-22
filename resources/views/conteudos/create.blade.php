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
        <input type="text" name="title"></br>
        Descrição:
        <textarea name="description"></textarea></br>
        Privado:
        <input type="checkbox" name="private"></br>
        Categoria:
        <select name="category"></br>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->nome}}</option>
            @endforeach
        </select></br>
        Tags (separadas por vírgulas):
        <input type="text" name="tags"></br>
        <input type="file" name="file"></br>
        <input type="submit" value="Upload" name="submit"></br>
    </form>
@endsection