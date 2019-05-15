<?php
$roles = \App\Role::all();
?>
@extends('layout.layout')
@section('title', 'Criar Utilizador')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    //TODO: <Password></Password>
    <form action="" method="post">
        @csrf
        Nome do Utilizador<br>
        <input type="text" name="name" value="{{$user->name ?? ''}}"><br>
        Email<br>
        <input type="email" name="email" value="{{$user->email ?? ''}}"><br>
        Grupo:<br>
        <select name="group">
            <?php

            foreach ($roles as $role) {
                if (isset($user)) {
                    echo "<option value='" . $role->name . "'" . ($user->hasRole($role->slug) ? 'selected' : '') . ">" . $role->name . "</option>";
                } else {
                    echo "<option value='" . $role->name . "'>" . $role->name . "</option>";
                }

            }

            ?>
        </select>
        <br>
        @isset($user)
            <input type="submit" value="Editar Utilizador">
        @else
            <input type="submit" value="Criar Novo Utilizador">
        @endisset
    </form>

@endsection