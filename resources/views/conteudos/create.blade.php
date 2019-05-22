@extends('layout.layout')
@section('title', 'Upload')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title">
        <textarea name="description"></textarea>
        <input type="checkbox" name="private">
        <input type="file" name="file">
        <input type="submit" value="Upload" name="submit">
    </form>
@endsection