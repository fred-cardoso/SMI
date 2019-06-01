@extends('layout.layout')
@section('title', 'Mostrar Categorias')
@section('content')

    <section class="content-header">
        <h1>
            @lang("categorias.categories")
            <small>@lang("categorias.list_cat")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li class="active"><i class="fa fa-book"></i> @lang("categorias.categories")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang("categorias.categories")</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>@lang("common.id")</th>
                                <th>@lang("common.name")</th>
                                <th>@lang("categorias.secondary")</th>
                                <th>@lang("common.actions")</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categorias as $cat)
                                <tr>
                                    <td>{{$cat->id}}</td>
                                    <td><a href="{{route('categorias.show', $cat->id)}}">{{$cat->nome}}</a></td>
                                    <td>{{$cat->secundaria}}</td>
                                    <td>
                                        @auth
                                            <form action="{{route("cat.subscribe", $cat->id)}}" method="POST">
                                                @csrf
                                                <?php $userAuth = Auth::User()->id;
                                                $database = DB::table("user_categoria")->get();
                                                $checkIfSubscribed = sizeof($database->where('categoria_id', $cat->id)->where('user_id', Auth::user()->id));
                                                if ($checkIfSubscribed == 0) {
                                                    echo '<input class="btn btn-secondary" name="sub"type="submit"value="Subscribe">';

                                                } else {
                                                    echo '<input class="btn btn-warning" name="sub" type="submit" value="Unsubscribe">';
                                                }

                                                ?>

                                                @role('simpatizante')
                                                @if(auth()->user()->hasRole('simpatizante'))
                                                    <a href="{{route('cat.edit', $cat->id)}}" type="button"
                                                       class="btn btn-primary">@lang("common.edit")</a>
                                                @endif
                                                @endrole
                                                @role('admin')
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete-cat-{{$cat->id}}" wfd-id="264">
                                                    @lang('common.delete')
                                                </button>
                                                @endrole
                                            </form>
                                    </td>
                                    @endauth
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>@lang("common.id")</th>
                                <th>@lang("common.name")</th>
                                <th>@lang("categorias.secondary")</th>
                                <th>@lang("common.actions")</th>
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
    @foreach($categorias as $cat)
        <div class="modal modal-danger fade" id="modal-delete-cat-{{$cat->id}}" wfd-id="130">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">@lang('common.warning')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('categorias.perm_delete')<b>{{$cat->nome}}</b> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            Cancelar
                        </button>
                        <form action="{{route('cat.delete', $cat->id)}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline" wfd-id="250" value="{{@__('common.delete')}}"/>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection