@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Clientes</h1>
        @can('crear_clientes')
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo cliente
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
            <form method="GET" action="{{ route('clientes.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ $search }}" class="form-control"
                               placeholder="Buscar por código, nombre, RFC o contacto">
                    </div>

                    <div class="col-md-3">
                        <select name="tipo" class="form-control">
                            <option value="">Todos los tipos</option>
                            <option value="privado" @selected($tipo === 'privado')>Privado</option>
                            <option value="integral" @selected($tipo === 'integral')>Integral</option>
                            <option value="mixto" @selected($tipo === 'mixto')>Mixto</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-info" type="submit">Buscar</button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Limpiar</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre comercial</th>
                        <th>Razón social</th>
                        <th>RFC</th>
                        <th>Tipo</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Estatus</th>
                        <th width="240">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->codigo ?: '-' }}</td>
                            <td>{{ $cliente->nombre_comercial }}</td>
                            <td>{{ $cliente->razon_social ?: '-' }}</td>
                            <td>{{ $cliente->rfc ?: '-' }}</td>
                            <td>{{ ucfirst($cliente->tipo_cliente) }}</td>
                            <td>{{ $cliente->contacto_principal ?: '-' }}</td>
                            <td>{{ $cliente->telefono ?: '-' }}</td>
                            <td>
                                @if($cliente->is_active)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('clientes.show', $cliente) }}" class="btn btn-sm btn-info">Ver</a>

                                @can('editar_clientes')
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">Editar</a>

                                    <form action="{{ route('clientes.toggle-active', $cliente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $cliente->is_active ? 'btn-secondary' : 'btn-success' }}" type="submit">
                                            {{ $cliente->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clientes->hasPages())
            <div class="card-footer">
                {{ $clientes->links() }}
            </div>
        @endif
    </div>
@stop