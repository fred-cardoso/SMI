@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <?php
    $role = Auth::user()->roles->first();
    foreach ($conteudos as $conteudo) {
        echo '<a href="uploads/' . $conteudo->id . '">' . $conteudo->titulo . '</a>&nbsp;';

        if ($role->slug == 'admin'){
            echo '<form action="uploads/' . $conteudo->id . '/delete" method="POST">';
            echo '<input type="submit" value="Eliminar">';
            ?>@csrf<?php
            echo '</br>';
            echo '</form>';
        }
    }
    ?>

@endsection