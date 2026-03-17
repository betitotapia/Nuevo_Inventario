@csrf

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo"
                   value="{{ old('codigo', $almacen->codigo ?? '') }}"
                   class="form-control @error('codigo') is-invalid @enderror" required>
            @error('codigo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                   value="{{ old('nombre', $almacen->nombre ?? '') }}"
                   class="form-control @error('nombre') is-invalid @enderror" required>
            @error('nombre')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="tipo_almacen">Tipo de almacén</label>
            <select name="tipo_almacen" id="tipo_almacen"
                    class="form-control @error('tipo_almacen') is-invalid @enderror" required>
                <option value="general" @selected(old('tipo_almacen', $almacen->tipo_almacen ?? 'general') === 'general')>General</option>
                <option value="padre" @selected(old('tipo_almacen', $almacen->tipo_almacen ?? '') === 'padre')>Padre</option>
                <option value="hijo" @selected(old('tipo_almacen', $almacen->tipo_almacen ?? '') === 'hijo')>Hijo</option>
                <option value="tecnico" @selected(old('tipo_almacen', $almacen->tipo_almacen ?? '') === 'tecnico')>Técnico</option>
            </select>
            @error('tipo_almacen')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="parent_id">Almacén padre</label>
            <select name="parent_id" id="parent_id"
                    class="form-control @error('parent_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach($padres as $padre)
                    <option value="{{ $padre->id }}"
                        @selected((string) old('parent_id', $almacen->parent_id ?? '') === (string) $padre->id)>
                        {{ $padre->codigo }} - {{ $padre->nombre }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <small class="text-muted">Solo aplica si el tipo es "Hijo".</small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="responsable_user_id">Responsable</label>
            <select name="responsable_user_id" id="responsable_user_id"
                    class="form-control @error('responsable_user_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}"
                        @selected((string) old('responsable_user_id', $almacen->responsable_user_id ?? '') === (string) $usuario->id)>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            @error('responsable_user_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" id="permite_privado" name="permite_privado"
                @checked(old('permite_privado', $almacen->permite_privado ?? false))>
            <label class="form-check-label" for="permite_privado">
                Permite privado
            </label>
        </div>
    </div>

    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" id="permite_integral" name="permite_integral"
                @checked(old('permite_integral', $almacen->permite_integral ?? false))>
            <label class="form-check-label" for="permite_integral">
                Permite integral
            </label>
        </div>
    </div>

    <div class="col-md-4 d-flex align-items-center">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                @checked(old('is_active', $almacen->is_active ?? true))>
            <label class="form-check-label" for="is_active">
                Activo
            </label>
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
</div>