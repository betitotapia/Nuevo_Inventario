@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Productos</h1>
        @can('crear_productos')
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo producto
            </a>
        @endcan
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('productos.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                               placeholder="Buscar por código, sku o descripción">
                    </div>

                    <div class="col-md-3">
                        <select name="estado" class="form-control">
                            <option value="">Todos</option>
                            <option value="activos" @selected($estado === 'activos')>Activos</option>
                            <option value="inactivos" @selected($estado === 'inactivos')>Inactivos</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-info" type="submit">Buscar</button>
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>SKU</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Unidad</th>
                        <th>Precio</th>
                        <th>Lote</th>
                        <th>Caducidad</th>
                        <th>Estatus</th>
                        <th width="240">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->codigo }}</td>
                            <td>{{ $producto->sku ?: '-' }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->categoria?->nombre ?: '-' }}</td>
                            <td>{{ $producto->unidad?->clave ?: '-' }}</td>
                            <td>${{ number_format((float) $producto->precio_base, 2) }}</td>
                            <td>{{ $producto->maneja_lote ? 'Sí' : 'No' }}</td>
                            <td>{{ $producto->maneja_caducidad ? 'Sí' : 'No' }}</td>
                            <td>
                                @if($producto->is_active)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-info">Ver</a>

                                @can('editar_productos')
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('productos.toggle-active', $producto) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $producto->is_active ? 'btn-secondary' : 'btn-success' }}" type="submit">
                                            {{ $producto->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($productos->hasPages())
            <div class="card-footer">
                {{ $productos->links() }}
            </div>
        @endif
    </div>
@stop