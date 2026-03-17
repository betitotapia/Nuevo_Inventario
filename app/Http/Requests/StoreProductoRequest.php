<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('crear_productos');
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:80', 'unique:productos,codigo'],
            'sku' => ['nullable', 'string', 'max:80'],
            'descripcion' => ['required', 'string', 'max:255'],
            'categoria_producto_id' => ['nullable', 'exists:categoria_productos,id'],
            'unidad_medida_id' => ['nullable', 'exists:unidad_medidas,id'],
            'maneja_lote' => ['nullable', 'boolean'],
            'maneja_caducidad' => ['nullable', 'boolean'],
            'precio_base' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}