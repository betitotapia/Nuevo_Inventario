@extends('adminlte::page')

@section('title', 'Almacenes autorizados')

@section('content_header')
    <h1>Almacenes autorizados de {{ $user->name }}</h1>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            Revisa la información capturada.
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong>Usuario:</strong> {{ $user->name }} <br>
            <strong>Correo:</strong> {{ $user->email }} <br>
            <strong>Operación:</strong> {{ ucfirst($user->tipo_operacion) }} <br>
            <strong>Almacén principal:</strong> {{ $user->almacen?->nombre ?? '-' }}
        </div>

        <form action="{{ route('usuarios.almacenes.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Asignar</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Consultar</th>
                            <th>Operar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($almacenes as $index => $almacen)
                            @php
                                $pivot = $asignados->get($almacen->id)?->pivot;
                                $checked = $asignados->has($almacen->id);
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox"
                                           name="almacenes[{{ $index }}][enabled]"
                                           value="1"
                                           class="form-check-input asignar-almacen"
                                           data-row="{{ $index }}"
                                           {{ $checked ? 'checked' : '' }}>
                                    <input type="hidden"
                                           name="almacenes[{{ $index }}][almacen_id]"
                                           value="{{ $almacen->id }}">
                                </td>
                                <td>{{ $almacen->codigo }}</td>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ ucfirst($almacen->tipo_almacen) }}</td>
                                <td>
                                    <input type="checkbox"
                                           name="almacenes[{{ $index }}][puede_consultar]"
                                           value="1"
                                           class="form-check-input permiso-row permiso-consultar-{{ $index }}"
                                           {{ $pivot && $pivot->puede_consultar ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input type="checkbox"
                                           name="almacenes[{{ $index }}][puede_operar]"
                                           value="1"
                                           class="form-check-input permiso-row permiso-operar-{{ $index }}"
                                           {{ $pivot && $pivot->puede_operar ? 'checked' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Guardar asignaciones</button>
                <a href="{{ route('usuarios.show', $user) }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
@stop