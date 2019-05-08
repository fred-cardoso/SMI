@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <?php
    echo $user->name;
    echo "</br>";
    echo $user->email;
    ?>
@endsection