@extends('layout.layout')
@section('title', __('categorias.categories'))
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
                @include('layout.result')
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
                                <th>@lang("categorias.type")</th>
                                @role('simpatizante')
                                <th>@lang("common.actions")</th>
                                @endrole
                            </tr>
                            </thead>
                            <tbody>
                            @if($categorias->count() == 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box box-primary">
                                            <div class="box-body">
                                               @lang('categorias.no_cat')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @foreach($categorias as $cat)
                                <tr>
                                    <td>{{$cat->id}}</td>
                                    <td><a href="{{route('categorias.show', $cat->id)}}">{{$cat->nome}}</a></td>
                                    <td>
                                        <span class="label label-{{$cat->secundaria == 1 ? 'info' : 'primary'}}">{{$cat->secundaria == 1 ?  __('categorias.secondary') : __('categorias.main')}}</span>
                                    </td>

                                    @auth
                                        <td>
                                            <form action="{{route("cat.subscribe", $cat->id)}}" method="POST">
                                                @csrf


                                                @role('simpatizante')
                                                @if(auth()->user()->hasRole('simpatizante') and !$cat->secundaria)
                                                @else
                                                    <a href="{{route('cat.edit', $cat->id)}}" type="button"
                                                       class="btn btn-primary">@lang("common.edit")</a>
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#modal-delete-category-{{$cat->id}}"
                                                            wfd-id="264">
                                                        @lang('common.delete')
                                                    </button>
                                                @endif
                                                @endrole
                                                <?php $userAuth = Auth::User()->id;
                                                $database = DB::table("user_categoria")->get();
                                                $checkIfSubscribed = sizeof($database->where('categoria_id', $cat->id)->where('user_id', Auth::user()->id));
                                                if ($checkIfSubscribed == 0) {
                                                    echo '<input class="btn btn-secondary" name="sub"type="submit"value="Subscribe">';

                                                } else {
                                                    echo '<input class="btn btn-warning" name="sub" type="submit" value="Unsubscribe">';
                                                }

                                                ?>
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
                                <th>@lang("categorias.type")</th>
                                @role('simpatizante')
                                <th>@lang("common.actions")</th>
                                @endrole
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
    @foreach($categorias as $categoria)
        @if(!$categoria->secundaria and (!auth()->check() or !auth()->user()->hasRole('admin')))
            @continue
        @endif
        <div class="modal modal-danger fade" id="modal-delete-category-{{$categoria->id}}" wfd-id="130">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">@lang('common.warning')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('categorias.perm_delete')<b>{{$categoria->nome}}</b> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            Cancelar
                        </button>
                        <form action="{{route('cat.delete', $categoria->id)}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline" wfd-id="250" value="{{__('common.delete')}}"/>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endforeach
@endsection