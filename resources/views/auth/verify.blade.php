@extends('layout.layout')
@section('title', __('auth.email_veri'))
@section('content')
    <section class="content">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                @lang("auth.resend_mail")
            </div>
    @endif
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">@lang("auth.verify_mail")</h3>
            </div>
            <div class="box-body">
                @lang("auth.verification_1")<a href="{{ route('verification.resend') }}">@lang("auth.verification_2")</a>.
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
@endsection
