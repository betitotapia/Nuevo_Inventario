@extends('adminlte::page')

@section('title', 'Existencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Existencias</h1>
        @can('crear_ajustes')
            <a href="{{ route('inventario.ajustes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo ajuste
            </a>
        @endcan
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('inventario.existencias') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                               placeholder="Buscar por código, sku o descripción">
                    </div>

                    <div class="col-md-3">
                        <select name="almacen_id" class="form-control">
                            <option value="">Todos los almacenes</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" @selected((string) $almacenId === (string) $almacen->id)>
                                    {{ $almacen->codigo }} - {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-info" type="submit">Buscar</button>
                        <a href="{{ route('inventario.existencias') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Almacén</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Lote</th>
                        <th>Caducidad</th>
                        <th>Ubicación</th>
                        <th>Cantidad</th>
                        <th>Costo promedio</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @forelse($existencias as $item)
                        <tr>
                            <td>{{ $item->almacen->nombre }}</td>
                            <td>{{ $item->producto->codigo }}</td>
                            <td>{{ $item->producto->descripcion }}</td>
                            <td>{{ $item->lote ?: '-' }}</td>
                            <td>{{ $item->caducidad ? $item->caducidad->format('Y-m-d') : '-' }}</td>
                            <td>{{ $item->ubicacion ?: '-' }}</td>
                            <td>{{ number_format((float) $item->cantidad, 3) }}</td>
                            <td>{{ number_format((float) $item->costo_promedio, 4) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay existencias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($existencias->hasPages())
            <div class="card-footer">
                {{ $existencias->links() }}
            </div>
        @endif
    </div>
@stop