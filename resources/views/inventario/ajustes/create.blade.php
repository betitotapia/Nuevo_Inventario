@extends('adminlte::page')

@section('title', 'Nuevo Ajuste de Inventario')

@section('content_header')
    <h1>Nuevo Ajuste de Inventario</h1>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventario.ajustes.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="tipo_movimiento">Tipo de ajuste</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-control" required>
                                <option value="entrada_ajuste" @selected(old('tipo_movimiento') === 'entrada_ajuste')>Entrada</option>
                                <option value="salida_ajuste" @selected(old('tipo_movimiento') === 'salida_ajuste')>Salida</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="almacen_id">Almacén</label>
                            <select name="almacen_id" id="almacen_id" class="form-control" required>
                                <option value="">Seleccione...</option>
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}" @selected((string) old('almacen_id') === (string) $almacen->id)>
                                        {{ $almacen->codigo }} - {{ $almacen->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('almacen_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="producto_id">Producto</label>
                            <select name="producto_id" id="producto_id" class="form-control" required>
                                <option value="">Seleccione...</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}" @selected((string) old('producto_id') === (string) $producto->id)>
                                        {{ $producto->codigo }} - {{ $producto->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('producto_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="lote">Lote</label>
                            <input type="text" name="lote" id="lote" class="form-control" value="{{ old('lote') }}">
                            @error('lote')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="caducidad">Caducidad</label>
                            <input type="date" name="caducidad" id="caducidad" class="form-control" value="{{ old('caducidad') }}">
                            @error('caducidad')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') }}"
                                placeholder="Ej. Rack A-02 / Nivel 1">
                            @error('ubicacion')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="costo_unitario">Costo unitario</label>
                            <input type="number" step="0.0001" min="0" name="costo_unitario" id="costo_unitario" class="form-control" value="{{ old('costo_unitario', 0) }}">
                            @error('costo_unitario')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="2" class="form-control">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Guardar ajuste</button>
                <a href="{{ route('inventario.ajustes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop