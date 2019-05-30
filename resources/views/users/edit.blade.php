@extends('layout.layout')
@section('title', 'Editar Utilizador')
@section('content')
    <section class="content-header">
        <h1>
            @lang('categorias.users')
            <small>@lang('common.edit'){{$user->name}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-dashboard"></i>@lang('categorias.home_page')</a></li>
            <li><a href="{{route("users")}}"><i class="fa fa-users"></i>@lang('categorias.users') </a></li>
            <li class="active">@lang('user.edit_user')</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                <form role="form" action="{{route('user.edit', $user->id)}}" method="POST">
                    @csrf
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('user.edit_user')</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- text input -->
                            <div class="form-group">
                                <label>@lang('common.name')</label>
                                <input type="text" name="name" class="form-control" value="{{old('name') ?? $user->name}}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('auth.email')</label>
                                <input type="email" name="email" class="form-control" value="{{old('email') ?? $user->email}}" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('common.role')</label>
                                <select name="group" class="form-control">
                                    @foreach($roles as $role)
                                        <option value="{{$role->name}}" {{$user->roles()->first()->name == $role->name ? 'selected' : ''}}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">@lang('common.edit')</button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </form>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection