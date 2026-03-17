@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usuarios.store') }}" method="POST">
                @include('usuarios._form')
            </form>
        </div>
    </div>
@stop