@extends('adminlte::page')

@section('title', 'Detalle de Almacén')

@section('content_header')
    <h1>Detalle de Almacén</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="250">Código</th>
                    <td>{{ $almacen->codigo }}</td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $almacen->nombre }}</td>
                </tr>
                <tr>
                    <th>Tipo</th>
                    <td>{{ ucfirst($almacen->tipo_almacen) }}</td>
                </tr>
                <tr>
                    <th>Almacén padre</th>
                    <td>{{ $almacen->parent?->nombre ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Responsable</th>
                    <td>{{ $almacen->responsable?->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Permite privado</th>
                    <td>{{ $almacen->permite_privado ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Permite integral</th>
                    <td>{{ $almacen->permite_integral ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Estatus</th>
                    <td>{{ $almacen->is_active ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            </table>

            @if($almacen->children->count())
                <div class="mt-4">
                    <h5>Almacenes hijos</h5>
                    <ul class="list-group">
                        @foreach($almacen->children as $child)
                            <li class="list-group-item">
                                {{ $child->codigo }} - {{ $child->nombre }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Volver</a>
                @can('editar_almacenes')
                    <a href="{{ route('almacenes.edit', $almacen) }}" class="btn btn-warning">Editar</a>
                @endcan
            </div>
        </div>
    </div>
@stop