@extends('adminlte::page')

@section('title', 'Detalle de Producto')

@section('content_header')
    <h1>Detalle de Producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="250">Código</th>
                    <td>{{ $producto->codigo }}</td>
                </tr>
                <tr>
                    <th>SKU</th>
                    <td>{{ $producto->sku ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Descripción</th>
                    <td>{{ $producto->descripcion }}</td>
                </tr>
                <tr>
                    <th>Categoría</th>
                    <td>{{ $producto->categoria?->nombre ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Unidad</th>
                    <td>{{ $producto->unidad?->clave ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Precio base</th>
                    <td>${{ number_format((float) $producto->precio_base, 2) }}</td>
                </tr>
                <tr>
                    <th>Maneja lote</th>
                    <td>{{ $producto->maneja_lote ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Maneja caducidad</th>
                    <td>{{ $producto->maneja_caducidad ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Estatus</th>
                    <td>{{ $producto->is_active ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
                @can('editar_productos')
                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">Editar</a>
                @endcan
            </div>
        </div>
    </div>
@stop