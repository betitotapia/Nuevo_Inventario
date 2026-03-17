@extends('adminlte::page')

@section('title', 'Detalle de Traspaso')

@section('content_header')
    <h1>Detalle de Traspaso</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="250">Folio</th>
                    <td>{{ $traspaso->folio }}</td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ $traspaso->fecha_traspaso?->format('Y-m-d H:i') }}</td>
                </tr>
                <tr>
                    <th>Origen</th>
                    <td>{{ $traspaso->origen?->nombre }}</td>
                </tr>
                <tr>
                    <th>Destino</th>
                    <td>{{ $traspaso->destino?->nombre }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td>{{ $traspaso->observaciones ?: '-' }}</td>
                </tr>
            </table>

            <h5 class="mt-4">Detalle</h5>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Lote</th>
                        <th>Caducidad</th>
                        <th>Ubicación origen</th>
                        <th>Ubicación destino</th>
                        <th>Cantidad</th>
                        <th>Costo unitario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($traspaso->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->producto?->descripcion }}</td>
                            <td>{{ $detalle->lote ?: '-' }}</td>
                            <td>{{ $detalle->caducidad ? $detalle->caducidad->format('Y-m-d') : '-' }}</td>
                            <td>{{ $detalle->ubicacion_origen ?: '-' }}</td>
                            <td>{{ $detalle->ubicacion_destino ?: '-' }}</td>
                            <td>{{ number_format((float) $detalle->cantidad, 3) }}</td>
                            <td>{{ number_format((float) $detalle->costo_unitario, 4) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('inventario.traspasos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop