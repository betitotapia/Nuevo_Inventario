@csrf

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo"
                   value="{{ old('codigo', $producto->codigo ?? '') }}"
                   class="form-control @error('codigo') is-invalid @enderror"
                   required>
            @error('codigo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku"
                   value="{{ old('sku', $producto->sku ?? '') }}"
                   class="form-control @error('sku') is-invalid @enderror">
            @error('sku')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="precio_base">Precio base</label>
            <input type="number" step="0.01" min="0" name="precio_base" id="precio_base"
                   value="{{ old('precio_base', isset($producto) ? $producto->precio_base : '0.00') }}"
                   class="form-control @error('precio_base') is-invalid @enderror"
                   required>
            @error('precio_base')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion"
           value="{{ old('descripcion', $producto->descripcion ?? '') }}"
           class="form-control @error('descripcion') is-invalid @enderror"
           required>
    @error('descripcion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="categoria_producto_id">Categoría</label>
            <select name="categoria_producto_id" id="categoria_producto_id"
                    class="form-control @error('categoria_producto_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        @selected((string) old('categoria_producto_id', $producto->categoria_producto_id ?? '') === (string) $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_producto_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="unidad_medida_id">Unidad de medida</label>
            <select name="unidad_medida_id" id="unidad_medida_id"
                    class="form-control @error('unidad_medida_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id }}"
                        @selected((string) old('unidad_medida_id', $producto->unidad_medida_id ?? '') === (string) $unidad->id)>
                        {{ $unidad->clave }} - {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
            @error('unidad_medida_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="maneja_lote" name="maneja_lote"
                @checked(old('maneja_lote', $producto->maneja_lote ?? false))>
            <label class="form-check-label" for="maneja_lote">
                Maneja lote
            </label>
        </div>
    </div>

    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="maneja_caducidad" name="maneja_caducidad"
                @checked(old('maneja_caducidad', $producto->maneja_caducidad ?? false))>
            <label class="form-check-label" for="maneja_caducidad">
                Maneja caducidad
            </label>
        </div>
    </div>

    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                @checked(old('is_active', $producto->is_active ?? true))>
            <label class="form-check-label" for="is_active">
                Producto activo
            </label>
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
</div>