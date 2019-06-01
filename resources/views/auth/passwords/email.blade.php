@extends('layout.layout')
@section('title', __('auth.email_veri'))
@section('content')
    <section class="content">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">{{__('auth.password_recovery')}}</h3>
            </div>
            <form method="POST" action="{{ route('password.email') }}" class="form-horizontal">
                <div class="box-body">
                    @csrf
                    <div class="form-group row">
                        <label for="email"
                               class="col-md-4 col-form-label text-md-right">@lang("email")</label>
                        <div class="col-sm-12">
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">
                       @lang("send_email_reco");
                    </button>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
@endsection
