@extends('layout.layout')
@section('title', 'Criar Categoria')
@section('content')
    @if(session()->has('erro'))
        <h3>{{session()->get('erro')}}</h3>
        @endif
    <form action="" method="post">
        @csrf
        Nome da Categoria<br>
        <input type="text" name="nomeCat"><br>
        Secundária:<br>
        <input type="checkbox" name="secundaria">
        <input type="submit" value="Criar">
    </form>

    <
    <?php

    /*foreach ($categoria as $cat) {
        echo $cat->nome;
    }*/

    ?>
@endsection