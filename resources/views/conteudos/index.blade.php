@extends('layout.layout')
@section('title', __("conteudos.list_content"))
@section('content')
    <section class="content-header">
        <h1>
            @lang("conteudos.content")
            <small>@lang("conteudos.list_content")</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route("home")}}"><i class="fa fa-home"></i>@lang("categorias.home_page")</a></li>
            <li class="active"><i class="fa fa-television"></i> @lang("conteudos.content")</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12" id="main_div">
                @include('layout.result')
                @auth
                    <form action="{{route('uploads.batch')}}" method="POST" id="mass_action_form">
                        @csrf
                        @endauth
                        <div class="box">
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        @auth
                                            <th style="width: 10px"></th>
                                        @endauth
                                        <th>@lang('common.id')</th>
                                        <th>@lang('conteudos.title')</th>
                                        <th>@lang('common.author')</th>
                                        <th>@lang('common.creation_date')</th>
                                        @role('admin')
                                        <th>@lang('common.visibility')</th>
                                        @endrole
                                        @role('simpatizante')
                                        <th>@lang('common.actions')</th>
                                        @endrole
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($conteudos->count() == 0)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-primary">
                                                    <div class="box-body">
                                                        @lang('common.no_content')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach($conteudos as $conteudo)
                                        @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
                                            @continue
                                        @endif
                                        <tr>

                                            @auth
                                                <td>
                                                    <input type="checkbox" name="selected[]" value="{{$conteudo->id}}">
                                                </td>
                                            @endauth

                                            <td>{{$conteudo->id}}</td>
                                            <td>
                                                <a href="{{route('uploads.show', $conteudo->id)}}">{{$conteudo->titulo}}</a>
                                            </td>
                                            <td>
                                                <a href="{{route('user', $conteudo->user()->first()->id)}}">{{$conteudo->user()->first()->name}}</a>
                                            </td>
                                            <td>{{$conteudo->created_at}}</td>
                                            @role('admin')
                                            <td>
                                                <span class="label label-{{$conteudo->privado == 1 ? 'danger' : 'success'}}">{{$conteudo->privado == 1 ? __('common.private') : __('common.public')}}</span>
                                            </td>
                                            @endrole
                                            @role('simpatizante')
                                            <td>
                                                @role('simpatizante')
                                                @if(auth()->user()->hasRole('simpatizante') and !$conteudo->isOwner(auth()->user()))

                                                @else
                                                    <a href="{{route('uploads.edit', $conteudo->id)}}" type="button"
                                                       class="btn btn-primary">@lang('common.edit')</a>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#modal-delete-content-{{$conteudo->id}}"
                                                            wfd-id="264">
                                                        @lang('common.delete')
                                                    </button>
                                                @endif
                                                @endrole
                                            </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        @auth
                                            <th></th>
                                        @endauth
                                        <th>@lang('common.id')</th>
                                        <th>@lang('conteudos.title')</th>
                                        <th>@lang('common.author')</th>
                                        <th>@lang('common.creation_date')</th>
                                        @role('admin')
                                        <th>@lang('common.visibility')</th>
                                        @endrole
                                        @role('simpatizante')
                                        <th>@lang('common.actions')</th>
                                        @endrole
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="box box-footer">
                                <div class="col-sm-2">
                                    @auth
                                        <label>@lang('conteudos.select_act')</label>
                                        <select class="form-control" id="action_selection" name="action"
                                                onchange="massAction()">
                                            <option value="">@lang('conteudos.select_option')</option>
                                            <option value="download">@lang('conteudos.download')</option>
                                            @role('simpatizante')
                                            <option value="visibility_public">@lang('conteudos.set_public')</option>
                                            <option value="visibility_private">@lang('conteudos.set_private')</option>
                                            <option value="delete">@lang('common.delete')</option>
                                            @endrole
                                        </select>
                                    @endauth
                                </div>
                                <div id="prepareDownload" class="col-sm-2" style="display:none">
                                    <label>@lang('conteudos.choose_pref')</label><br>
                                    <input type="checkbox" name="request_category">@lang('conteudos.request_cat')<br>
                                    <input type="checkbox" name="request_description">@lang('conteudos.request_desc')
                                </div>
                                <div class="col-sm-2" id="prepareDownloadbut" style="display:none">
                                    <button type="button" onclick="submitform()" class="btn btn-success">@lang('conteudos.download')
                                    </button>
                                </div>
                                <div class="col-sm-5 text-right">
                                    {{$conteudos->links()}}
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        @auth
                    </form>
            @endauth
            <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    @foreach($conteudos as $conteudo)
        @if($conteudo->privado and (!auth()->check() or (!auth()->user()->hasRole('admin') and !$conteudo->isOwner(auth()->user()))))
            @continue
        @endif
        <div class="modal modal-danger fade" id="modal-delete-content-{{$conteudo->id}}" wfd-id="130">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar" wfd-id="252">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">@lang('common.warning')</h4>
                    </div>
                    <div class="modal-body">
                        <p>@lang('conteudos.perm_delete') <b>{{$conteudo->titulo}}</b> ? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" wfd-id="251">
                            @lang('categorias.cancel')
                        </button>
                        <form action="{{route('uploads.delete', $conteudo->id)}}" method="POST">
                            @csrf
                            <input type="submit" class="btn btn-outline" wfd-id="250"
                                   value="@lang("conteudos.delete_content")">
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

        </div>
    @endforeach
@endsection
@section('scripts')
    <script>
        function massAction() {
            var request = document.getElementById("prepareDownload");
            var requestButton = document.getElementById("prepareDownloadbut");
            let selected = document.getElementById('action_selection');
            let selected_values = selected.options[selected.selectedIndex].value;
            if (selected_values != null) {

                if (selected_values == "") {
                    request.style.display = "none";
                    requestButton.style.display = "none";
                    return;
                }

                if (selected_values == "delete") {
                    alert(@lang('common.delete_selected'));
                }


                let form = document.getElementById('mass_action_form');
                let contents = document.getElementsByName('selected[]');

                for ($i = 0; $i < contents.length; $i++) {
                    if (contents.item($i).checked) {
                        if (selected_values == "download") {

                            request.removeAttribute('style');
                            requestButton.removeAttribute('style');
                            return;
                        }else{
                            console.log("entrou");
                            request.style.display = "none";
                            requestButton.style.display = "none";
                        }

                        form.submit();
                        selected.value = selected.options[0].value;
                        return;
                    }
                }

                let main_div = document.getElementById('main_div');

                let content_alert = document.getElementById('contents_alert');
                if (content_alert != null) {
                    main_div.removeChild(content_alert);
                }

                let alert_div = document.createElement('template');
                alert_div.innerHTML = '<div class="alert alert-danger" id="contents_alert">@lang('common.select_first')</div>';

                main_div.insertBefore(alert_div.content.childNodes[0], main_div.childNodes[0]);

                selected.selectedIndex = 0;
            }
        }

        function submitform() {
            let selected = document.getElementById('action_selection');
            let form = document.getElementById('mass_action_form');
            let contents = document.getElementsByName('selected[]');

            for ($i = 0; $i < contents.length; $i++) {
                if (contents.item($i).checked) {
                    form.submit();
                    selected.value = selected.options[0].value;
                    return;
                }
            }
            let main_div = document.getElementById('main_div');

            let content_alert = document.getElementById('contents_alert');
            if (content_alert != null) {
                main_div.removeChild(content_alert);
            }

            let alert_div = document.createElement('template');
            alert_div.innerHTML = '<div class="alert alert-danger" id="contents_alert">@lang('common.select_first')</div>';

            main_div.insertBefore(alert_div.content.childNodes[0], main_div.childNodes[0]);

            selected.selectedIndex = 0;
        }
    </script>
@endsection