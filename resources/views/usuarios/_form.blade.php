@csrf

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name ?? '') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="email">Correo</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email ?? '') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="tipo_operacion">Tipo de operación</label>
            <select name="tipo_operacion" id="tipo_operacion"
                    class="form-control @error('tipo_operacion') is-invalid @enderror" required>
                <option value="privado" @selected(old('tipo_operacion', $user->tipo_operacion ?? 'privado') === 'privado')>Privado</option>
                <option value="integral" @selected(old('tipo_operacion', $user->tipo_operacion ?? '') === 'integral')>Integral</option>
                <option value="ambos" @selected(old('tipo_operacion', $user->tipo_operacion ?? '') === 'ambos')>Ambos</option>
            </select>
            @error('tipo_operacion')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="clave_remision">Clave remisión</label>
            <input type="text" name="clave_remision" id="clave_remision"
                   value="{{ old('clave_remision', $user->clave_remision ?? '') }}"
                   class="form-control @error('clave_remision') is-invalid @enderror"
                   maxlength="10">
            @error('clave_remision')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="role">Rol</label>
            <select name="role" id="role"
                    class="form-control @error('role') is-invalid @enderror" required>
                <option value="">Seleccione...</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}"
                        @selected(old('role', isset($user) ? $user->roles->first()?->name : '') === $role)>
                        {{ ucfirst(str_replace('_', ' ', $role)) }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="almacen_id">Almacén principal</label>
            <select name="almacen_id" id="almacen_id"
                    class="form-control @error('almacen_id') is-invalid @enderror">
                <option value="">Seleccione...</option>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}"
                        @selected((string) old('almacen_id', $user->almacen_id ?? '') === (string) $almacen->id)>
                        {{ $almacen->codigo }} - {{ $almacen->nombre }}
                    </option>
                @endforeach
            </select>
            @error('almacen_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password">{{ isset($user) ? 'Nueva contraseña' : 'Contraseña' }}</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   {{ isset($user) ? '' : 'required' }}>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            @if(isset($user))
                <small class="text-muted">Déjalo vacío si no deseas cambiarla.</small>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control">
        </div>
    </div>

    <div class="col-md-6 d-flex align-items-center">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active"
                @checked(old('is_active', $user->is_active ?? true))>
            <label class="form-check-label" for="is_active">
                Usuario activo
            </label>
        </div>
    </div>
</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        Guardar
    </button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
        Cancelar
    </a>
</div>