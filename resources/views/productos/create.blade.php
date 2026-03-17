@extends('adminlte::page')

@section('title', 'Nuevo Producto')

@section('content_header')
    <h1>Nuevo Producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="POST">
                @include('productos._form')
            </form>
        </div>
    </div>
@stop