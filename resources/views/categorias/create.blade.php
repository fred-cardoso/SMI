@extends('layout.layout')
@section('title', 'Criar Categoria')
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
    <form action="" method="post">
        @csrf
        Nome da Categoria<br>
        <input type="text" name="nomeCat" value="{{$categoria->nome ?? ''}}" ><br>
        Secundária:<br>
        <input type="checkbox" name="secundaria" value="{{$categoria->secundaria ?? ''}}">
        <br>
        @isset($categoria)
            <input type="submit" value="Editar Categoria">
        @else
            <input type="submit" value="Criar Nova Categoria">
        @endisset
    </form>


    <?php

    /*foreach ($categoria as $cat) {
        echo $cat->nome;
    }*/

    ?>
@endsection