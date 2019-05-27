<?php
use Illuminate\Support\Facades\Storage;
?>
@extends('layout.layout')
@section('title', $conteudo->titulo)
@section('content')
    <div>
        {{$conteudo->titulo}}
        </br>
        {{$conteudo->descricao}}
        </br>
        @if($conteudo->tipo == "video")
            Video
        @else
            <img src="data:image/jpeg;base64,{{base64_encode(Storage::get($conteudo->nome))}}" />
        @endif
    </div>
@endsection