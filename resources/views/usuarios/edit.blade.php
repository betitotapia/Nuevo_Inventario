@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $user) }}" method="POST">
                @method('PUT')
                @include('usuarios._form')
            </form>
        </div>
    </div>
@stop