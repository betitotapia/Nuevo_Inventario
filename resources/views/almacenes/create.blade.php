@extends('adminlte::page')

@section('title', 'Nuevo Almacén')

@section('content_header')
    <h1>Nuevo Almacén</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('almacenes.store') }}" method="POST">
                @include('almacenes._form')
            </form>
        </div>
    </div>
@stop