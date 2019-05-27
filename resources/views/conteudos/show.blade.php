@extends('layout.layout')
@section('title', $conteudo->titulo)
@section('content')
    <?php
    echo $conteudo->titulo;
    echo "</br>";
    echo $conteudo->descricao;
    ?>
@endsection