@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                @method('PUT')
                @include('clientes._form')
            </form>
        </div>
    </div>
@stop