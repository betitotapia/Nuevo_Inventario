@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Usuarios</h1>
        @can('crear_usuarios')
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo usuario
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
            <form method="GET" action="{{ route('usuarios.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                               placeholder="Buscar por nombre, correo o clave">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info" type="submit">Buscar</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Operación</th>
                        <th>Clave</th>
                        <th>Almacén</th>
                        <th>Estatus</th>
                        <th width="220">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $user->rol_principal ?? 'Sin rol')) }}</td>
                            <td>{{ ucfirst($user->tipo_operacion) }}</td>
                            <td>{{ $user->clave_remision ?: '-' }}</td>
                            <td>{{ $user->almacen?->nombre ?: '-' }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('usuarios.show', $user) }}" class="btn btn-sm btn-info">
                                    Ver
                                </a>

                                @can('editar_usuarios')
                                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">
                                        Editar
                                    </a>

                                    <form action="{{ route('usuarios.toggle-active', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $user->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                type="submit">
                                            {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@stop