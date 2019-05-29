@extends('layout.layout')
@section('title', 'Categorias')
@section('content')
    <?php

        echo $categoria->nome;
        echo "</br>";
        echo $categoria->secundaria;

    ?>
@endsection