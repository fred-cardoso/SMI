@extends('layout.layout')
@section('title', 'Mostrar Categorias')
@section('content')

<?php

foreach ($categorias as $cat) {
    echo $cat;
    echo "</br>";
    echo '<form action="categorias/' . $cat->id . '/subscribe" method="POST">';
    ?>@csrf<?php
    echo '<input type="submit" value="Subscrever"></form>';
    echo '</form>';
}


?>
@endsection
