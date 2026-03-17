@extends('adminlte::page')

@section('title', 'Traspasos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Traspasos</h1>
        <a href="{{ route('inventario.traspasos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo traspaso
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
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Estatus</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($traspasos as $traspaso)
                        <tr>
                            <td>{{ $traspaso->folio }}</td>
                            <td>{{ $traspaso->fecha_traspaso?->format('Y-m-d H:i') }}</td>
                            <td>{{ $traspaso->origen?->nombre }}</td>
                            <td>{{ $traspaso->destino?->nombre }}</td>
                            <td>{{ ucfirst($traspaso->estatus) }}</td>
                            <td>{{ $traspaso->creador?->name }}</td>
                            <td>
                                <a href="{{ route('inventario.traspasos.show', $traspaso) }}" class="btn btn-sm btn-info">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay traspasos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($traspasos->hasPages())
            <div class="card-footer">
                {{ $traspasos->links() }}
            </div>
        @endif
    </div>
@stop