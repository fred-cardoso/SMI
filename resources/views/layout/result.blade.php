@if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-ban"></i> Atenção!</h4>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{session('success')}}
    </div>
@endif