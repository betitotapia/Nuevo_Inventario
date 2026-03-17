<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('crear_usuarios');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_operacion' => ['required', Rule::in(['privado', 'integral', 'ambos'])],
            'clave_remision' => ['nullable', 'string', 'max:10', 'unique:users,clave_remision'],
            'almacen_id' => ['nullable', 'exists:almacens,id'],
            'is_active' => ['nullable', 'boolean'],
            'role' => ['required', 'exists:roles,name'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $role = $this->input('role');
            $clave = trim((string) $this->input('clave_remision'));

            if (in_array($role, ['ventas_privado', 'tecnico_integral'], true) && $clave === '') {
                $validator->errors()->add('clave_remision', 'La clave de remisión es obligatoria para vendedores y técnicos.');
            }
        });
    }
}