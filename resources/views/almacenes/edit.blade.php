@extends('adminlte::page')

@section('title', 'Editar Almacén')

@section('content_header')
    <h1>Editar Almacén</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('almacenes.update', $almacen) }}" method="POST">
                @method('PUT')
                @include('almacenes._form')
            </form>
        </div>
    </div>
@stop