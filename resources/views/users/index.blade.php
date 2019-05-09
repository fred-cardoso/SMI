@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    //TODO: Sucesso ou erro ao eliminar users
    <?php
    foreach ($users as $user) {
        echo '<a href="users/' . $user->id . '/edit">' . $user->name . '</a>&nbsp;';
        echo '<form action="users/' . $user->id . '/delete" method="POST">';
        ?>@csrf<?php
        echo '<input type="submit" value="Eliminar"></form>';
        echo '</br>';
    }
    ?>
@endsection