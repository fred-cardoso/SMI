@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    //TODO: Sucesso ou erro ao eliminar users

    <?php
    $role = Auth::user()->roles->first();
    foreach ($users as $user) {


    echo '<a href="users/' . $user->id . '/edit">' . $user->name . '</a>&nbsp;';
    echo '<form action="users/' . $user->id . '/delete" method="POST">';
    ?>@csrf<?php

    if ($role->slug == 'admin'){
    echo '<input type="submit" value="Eliminar"></form>';
    }
    echo '</br>';
    echo '</form>';
    echo '<form action="users/' . $user->id . '/subscribe" method="POST">';
    echo '<input type="submit" value="Subscrever"></form>' ;
    echo '</form>';


    }
    ?>

@endsection