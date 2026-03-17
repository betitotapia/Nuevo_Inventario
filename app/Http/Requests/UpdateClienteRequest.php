<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('editar_clientes');
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente')->id;

        return [
            'codigo' => ['nullable', 'string', 'max:30', Rule::unique('clientes', 'codigo')->ignore($clienteId)],
            'nombre_comercial' => ['required', 'string', 'max:255'],
            'razon_social' => ['nullable', 'string', 'max:255'],
            'rfc' => ['nullable', 'string', 'max:20'],
            'tipo_cliente' => ['required', Rule::in(['privado', 'integral', 'mixto'])],
            'telefono' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'direccion' => ['nullable', 'string'],
            'contacto_principal' => ['nullable', 'string', 'max:150'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}