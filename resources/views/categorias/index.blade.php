@extends('layout.layout')
@section('title', 'Mostrar Categorias')
@section('content')

    <section class="content-header">
        <h1>
            Categorias
            <small>Lista de Categorias</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i> Página Inicial</a></li>
            <li class="active">Categorias</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Categorias</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Secundária</th>
                                <th>Acções</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorias as $cat)
                                <tr>
                                    <td>{{$cat->id}}</td>
                                    <td><a href="{{route('categorias', $cat->id)}}">{{$cat->nome}}</td>
                                    <td>{{$cat->secundaria}}</td>
                                    <td>
                                        @auth
                                            <form action="{{route("cat.subscribe", $cat->id)}}" method="POST">
                                                @csrf
                                                <?php $userAuth = Auth::User()->id;
                                                $database = DB::table("user_categoria")->get();
                                                $checkIfSubscribed = sizeof($database->where('categoria_id', $cat->id)->where('user_id', Auth::user()->id));
                                                if ($checkIfSubscribed == 0) {
                                                    echo '<input class="btn btn-secondary" name="sub"type="submit" value="Subscribe">';

                                                } else {
                                                    echo '<input class="btn btn-warning" name="sub" type="submit" value="Unsubscribe">';
                                                }

                                                ?>

                                                <?php $role = Auth::user()->roles->first();?>
                                                @role('admin')
                                                <a href="{{route('cat.edit', $cat->id)}}" type="button"
                                                   class="btn btn-primary">Editar</a>
                                                @endrole
                                            </form>
                                    </td>
                                    @endauth
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Secundária</th>
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
@endsection