@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <?php
    foreach ($users as $user) {
        echo '<a href="users/' . $user->id . '">' . $user->name . '</a>';
    }
    ?>
@endsection