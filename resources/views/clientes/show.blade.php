@extends('adminlte::page')

@section('title', 'Detalle de Cliente')

@section('content_header')
    <h1>Detalle de Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="250">Código</th>
                    <td>{{ $cliente->codigo ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Nombre comercial</th>
                    <td>{{ $cliente->nombre_comercial }}</td>
                </tr>
                <tr>
                    <th>Razón social</th>
                    <td>{{ $cliente->razon_social ?: '-' }}</td>
                </tr>
                <tr>
                    <th>RFC</th>
                    <td>{{ $cliente->rfc ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Tipo de cliente</th>
                    <td>{{ ucfirst($cliente->tipo_cliente) }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td>{{ $cliente->telefono ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Correo</th>
                    <td>{{ $cliente->email ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Contacto principal</th>
                    <td>{{ $cliente->contacto_principal ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Dirección</th>
                    <td>{{ $cliente->direccion ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Estatus</th>
                    <td>{{ $cliente->is_active ? 'Activo' : 'Inactivo' }}</td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Volver</a>
                @can('editar_clientes')
                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning">Editar</a>
                @endcan
            </div>
        </div>
    </div>
@stop