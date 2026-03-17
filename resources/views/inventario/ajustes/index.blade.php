@extends('adminlte::page')

@section('title', 'Ajustes de Inventario')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Ajustes de Inventario</h1>
        <a href="{{ route('inventario.ajustes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo ajuste
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Almacén</th>
                        <th>Producto</th>
                        <th>Lote</th>
                        <th>Caducidad</th>
                        <th>Ubicación</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->fecha_movimiento?->format('Y-m-d H:i') }}</td>
                            <td>{{ $movimiento->tipo_movimiento }}</td>
                            <td>{{ $movimiento->almacen?->nombre }}</td>
                            <td>{{ $movimiento->producto?->descripcion }}</td>
                            <td>{{ $movimiento->lote ?: '-' }}</td>
                            <td>{{ $movimiento->caducidad ? $movimiento->caducidad->format('Y-m-d') : '-' }}</td>
                            <td>{{ $movimiento->ubicacion ?: '-' }}</td>
                            <td>{{ number_format((float) $movimiento->cantidad, 3) }}</td>
                            <td>{{ $movimiento->user?->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay movimientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movimientos->hasPages())
            <div class="card-footer">
                {{ $movimientos->links() }}
            </div>
        @endif
    </div>
@stop