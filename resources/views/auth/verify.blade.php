@extends('layout.layout')
@section('title', 'Verificação de Email')
@section('content')
    <section class="content">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                Foi reenviado um email de verificação para o seu email.
            </div>
    @endif
    <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Verifique o seu email</h3>
            </div>
            <div class="box-body">
                Antes de continuar, por favor verifique o seu email.
                Se não recebeu o email, <a href="{{ route('verification.resend') }}">clique aqui para voltar a
                    enviar</a>.
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
@endsection
