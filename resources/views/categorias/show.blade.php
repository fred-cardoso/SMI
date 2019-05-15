@extends('layout.layout')
@section('title', 'Categorias')
@section('content')
    <?php
    echo $categorias->name;
    echo "</br>";
    echo $categorias->secundaria;
    ?>
@endsection