@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <?php

    $role = Auth::user()->roles->first();
    /*foreach ($users as $user) {

    if ($role->slug == 'admin'){
    echo '<form action="users/' . $user->id . '/delete" method="POST">';
    ?>@csrf<?php
    echo '<input type="submit" value="Eliminar"></form>';
    echo '</br>';
    echo '</form>';


    }

    echo '<form action="users/' . $user->id . '/subscribe" method="POST">';
    ?>@csrf<?php
    echo '<input type="submit" value="Subscrever"></form>';
    echo '</form>';
    }*/
    ?>
    <section class="content-header">
        <h1>
            Utilizadores
            <small>Lista de Utilizadores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li class="active">Utilizadores</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Utilizadores</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Grupo</th>
                                <th>Acções</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->roles()->first()->name}}</td>
                                    <td>
                                        @if($role->slug == 'admin')
                                            <a href="{{route('user_edit', $user->id)}}" type="button"
                                               class="btn btn-primary">Editar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Grupo</th>
                                <th>Acções</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection