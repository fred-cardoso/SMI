@extends('layout.layout')
@section('title', __('categorias.users'))
@section('content')
    <section class="content-header">
        <h1>
            @lang('categorias.users')
            <small>@lang('user.list')</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i> @lang('categorias.home_page')</a></li>
            <li class="active"><i class="fa fa-users"></i> @lang('categorias.users')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                @include('layout.result')
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">@lang('categorias.users')</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if($users->count() == 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            Não existem utilizadores banidos!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>@lang('common.id')</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.role')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td><a href="{{route('user', $user->id)}}">{{$user->name}}</a></td>
                                        <td>{{$user->roles()->first()->name}}</td>
                                        <form action="{{route('users.unban', $user->id)}}"
                                              method="POST">
                                            <td>
                                                @auth
                                                    @role('admin')
                                                    <a href="{{route('user.edit', $user->id)}}" type="button"
                                                       class="btn btn-primary">@lang('common.edit')</a>
                                                    @if(auth()->user()->id != $user->id)
                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                                data-target="#modal-delete-user-{{$user->id}}"
                                                                wfd-id="264">
                                                            @lang('common.delete')
                                                        </button>
                                                    @endif
                                                    @csrf
                                                    <input type="submit" class="btn btn-success" wfd-id="264"
                                                           value="@lang('user.unban')">
                                                    @endrole
                                            </td>
                                        </form>
                                        @endauth
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>@lang('common.id')</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('common.role')</th>
                                    <th>@lang('common.actions')</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
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
        @if(!auth()->check() or auth()->user()->id == $user->id)
            @continue
        @endif
        <div class="modal modal-danger fade" id="modal-delete-user-{{$user->id}}" wfd-id="130">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">@lang('common.warning')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('user.perm_delete')<b>{{$user->name}}</b> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            Cancelar
                        </button>
                        <form action="{{route('user.delete', $user->id)}}" method="POST">
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