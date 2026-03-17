@extends('adminlte::page')

@section('title', 'Nuevo Traspaso')

@section('content_header')
    <h1>Nuevo Traspaso</h1>
@stop

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inventario.traspasos.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label>Almacén origen</label>
                        <select name="almacen_origen_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" @selected(old('almacen_origen_id') == $almacen->id)>
                                    {{ $almacen->codigo }} - {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Almacén destino</label>
                        <select name="almacen_destino_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" @selected(old('almacen_destino_id') == $almacen->id)>
                                    {{ $almacen->codigo }} - {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <h5>Detalle</h5>

                <div class="row">
                    <div class="col-md-2"><label>Producto</label></div>
                    <div class="col-md-1"><label>Lote</label></div>
                    <div class="col-md-2"><label>Caducidad</label></div>
                    <div class="col-md-2"><label>Ubicación origen</label></div>
                    <div class="col-md-2"><label>Ubicación destino</label></div>
                    <div class="col-md-1"><label>Cantidad</label></div>
                    <div class="col-md-2"><label>Costo unitario</label></div>
                </div>

                @for($i = 0; $i < 3; $i++)
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <select name="items[{{ $i }}][producto_id]" class="form-control">
                                <option value="">Seleccione...</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->codigo }} - {{ $producto->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <input type="text" name="items[{{ $i }}][lote]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="date" name="items[{{ $i }}][caducidad]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="items[{{ $i }}][ubicacion_origen]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="text" name="items[{{ $i }}][ubicacion_destino]" class="form-control">
                        </div>

                        <div class="col-md-1">
                            <input type="number" step="0.001" min="0" name="items[{{ $i }}][cantidad]" class="form-control">
                        </div>

                        <div class="col-md-2">
                            <input type="number" step="0.0001" min="0" name="items[{{ $i }}][costo_unitario]" class="form-control">
                        </div>
                    </div>
                @endfor

                <div class="form-group mt-3">
                    <label>Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar traspaso</button>
                <a href="{{ route('inventario.traspasos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop