@extends('layout.layout')
@section('title', 'Utilizadores')
@section('content')
    <section class="content-header">
        <h1>
            Utilizadores
            <small>Lista de Utilizadores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
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
                                    <td><a href="{{route('user', $user->id)}}">{{$user->name}}</a></td>
                                    <td>{{$user->roles()->first()->name}}</td>
                                    <td>
                                        <form action="{{route('user.subscribe', $user->id)}}" method="POST">
                                            @csrf
                                            <?php $userAuth = Auth::User()->id;
                                            $database = DB::table("user_user")->get();
                                            $checkIfSubscribed = sizeof($database->where('subscribed_id', $userAuth && 'user_id', $user->id));

                                            if ($checkIfSubscribed == 0) {
                                                echo '<input name="sub"type="submit" value="Subscribe">';


                                            } else {
                                                echo '<input name="sub" type="submit" value="Unsubscribe">';
                                            }

                                            ?>
                                        </form>
                                        @if($role->slug == 'admin')
                                            <a href="{{route('user.edit', $user->id)}}" type="button"
                                               class="btn btn-primary">Editar</a>
                                            @if(auth()->user()->id != $user->id)
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete-user-{{$user->id}}" wfd-id="264">
                                                    Eliminar
                                                </button>
                                            @endif
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
    @foreach($users as $user)
        @if(auth()->user()->id == $user->id)
            @continue
        @endif
        <div class="modal modal-danger fade" id="modal-delete-user-{{$user->id}}" wfd-id="130">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Alerta!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Pretende eliminar o utilizador <b>{{$user->name}}</b> permanentemente?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            Cancelar
                        </button>
                        <form action="{{route('user.delete', $user->id)}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline" wfd-id="250" value="Eliminar Utilizador"/>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection