<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAjusteInventarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('crear_ajustes');
    }

    public function rules(): array
    {
        return [
            'tipo_movimiento' => ['required', Rule::in(['entrada_ajuste', 'salida_ajuste'])],
            'almacen_id' => ['required', 'exists:almacens,id'],
            'producto_id' => ['required', 'exists:productos,id'],
            'lote' => ['nullable', 'string', 'max:80'],
            'caducidad' => ['nullable', 'date'],
            'ubicacion' => ['nullable', 'string', 'max:100'],
            'cantidad' => ['required', 'numeric', 'gt:0'],
            'costo_unitario' => ['nullable', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string'],
        ];
    }
}