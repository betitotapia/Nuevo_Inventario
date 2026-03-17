@csrf

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="codigo">Código</label>
            <input type="text" name="codigo" id="codigo"
                   value="{{ old('codigo', $cliente->codigo ?? '') }}"
                   class="form-control @error('codigo') is-invalid @enderror">
            @error('codigo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="nombre_comercial">Nombre comercial</label>
            <input type="text" name="nombre_comercial" id="nombre_comercial"
                   value="{{ old('nombre_comercial', $cliente->nombre_comercial ?? '') }}"
                   class="form-control @error('nombre_comercial') is-invalid @enderror"
                   required>
            @error('nombre_comercial')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="razon_social">Razón social</label>
            <input type="text" name="razon_social" id="razon_social"
                   value="{{ old('razon_social', $cliente->razon_social ?? '') }}"
                   class="form-control @error('razon_social') is-invalid @enderror">
            @error('razon_social')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="rfc">RFC</label>
            <input type="text" name="rfc" id="rfc"
                   value="{{ old('rfc', $cliente->rfc ?? '') }}"
                   class="form-control @error('rfc') is-invalid @enderror">
            @error('rfc')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="tipo_cliente">Tipo de cliente</label>
            <select name="tipo_cliente" id="tipo_cliente"
                    class="form-control @error('tipo_cliente') is-invalid @enderror" required>
                <option value="privado" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? 'privado') === 'privado')>Privado</option>
                <option value="integral" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') === 'integral')>Integral</option>
                <option value="mixto" @selected(old('tipo_cliente', $cliente->tipo_cliente ?? '') === 'mixto')>Mixto</option>
            </select>
            @error('tipo_cliente')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono"
                   value="{{ old('telefono', $cliente->telefono ?? '') }}"
                   class="form-control @error('telefono') is-invalid @enderror">
            @error('telefono')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="email">Correo</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $cliente->email ?? '') }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="contacto_principal">Contacto principal</label>
            <input type="text" name="contacto_principal" id="contacto_principal"
                   value="{{ old('contacto_principal', $cliente->contacto_principal ?? '') }}"
                   class="form-control @error('contacto_principal') is-invalid @enderror">
            @error('contacto_principal')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label for="direccion">Dirección</label>
    <textarea name="direccion" id="direccion" rows="3"
              class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $cliente->direccion ?? '') }}</textarea>
    @error('direccion')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
        @checked(old('is_active', $cliente->is_active ?? true))>
    <label class="form-check-label" for="is_active">
        Cliente activo
    </label>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
</div>