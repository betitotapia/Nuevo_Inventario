@extends('adminlte::page')

@section('title', 'Almacenes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Almacenes</h1>
        @can('crear_almacenes')
            <a href="{{ route('almacenes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo almacén
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
            <form method="GET" action="{{ route('almacenes.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                               placeholder="Buscar por código o nombre">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info" type="submit">Buscar</button>
                        <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Padre</th>
                        <th>Responsable</th>
                        <th>Privado</th>
                        <th>Integral</th>
                        <th>Estatus</th>
                        <th width="240">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($almacenes as $almacen)
                        <tr>
                            <td>{{ $almacen->codigo }}</td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ ucfirst($almacen->tipo_almacen) }}</td>
                            <td>{{ $almacen->parent?->nombre ?? '-' }}</td>
                            <td>{{ $almacen->responsable?->name ?? '-' }}</td>
                            <td>
                                @if($almacen->permite_privado)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($almacen->permite_integral)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($almacen->is_active)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('almacenes.show', $almacen) }}" class="btn btn-sm btn-info">Ver</a>

                                @can('editar_almacenes')
                                    <a href="{{ route('almacenes.edit', $almacen) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('almacenes.toggle-active', $almacen) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $almacen->is_active ? 'btn-secondary' : 'btn-success' }}" type="submit">
                                            {{ $almacen->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay almacenes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($almacenes->hasPages())
            <div class="card-footer">
                {{ $almacenes->links() }}
            </div>
        @endif
    </div>
@stop