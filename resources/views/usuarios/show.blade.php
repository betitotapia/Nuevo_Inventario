@extends('adminlte::page')

@section('title', 'Detalle de Usuario')

@section('content_header')
    <h1>Detalle de Usuario</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="250">Nombre</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Rol</th>
                    <td>{{ ucfirst(str_replace('_', ' ', $user->rol_principal ?? 'Sin rol')) }}</td>
                </tr>
                <tr>
                    <th>Tipo de operación</th>
                    <td>{{ ucfirst($user->tipo_operacion) }}</td>
                </tr>
                <tr>
                    <th>Clave remisión</th>
                    <td>{{ $user->clave_remision ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Almacén principal</th>
                    <td>{{ $user->almacen?->nombre ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Estatus</th>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
                @can('editar_usuarios')
                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-warning">Editar</a>
                @endcan
                @can('editar_usuarios')
                    <a href="{{ route('usuarios.almacenes', $user) }}" class="btn btn-info">
                        Almacenes autorizados
                    </a>
                @endcan
            </div>
        </div>
    </div>
@stop