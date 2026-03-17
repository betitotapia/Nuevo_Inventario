@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <h1>Editar Producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('productos.update', $producto) }}" method="POST">
                @method('PUT')
                @include('productos._form')
            </form>
        </div>
    </div>
@stop