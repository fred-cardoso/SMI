@extends('layout.layout')
@section('title', 'Mostrar Categorias')
@section('content')

<?php

foreach ($categorias as $cat) {
    echo $cat->nome;
    echo "</br>";
}

?>
@endsection
