<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('editar_productos');
    }

    public function rules(): array
    {
        $productoId = $this->route('producto')->id;

        return [
            'codigo' => ['required', 'string', 'max:80', Rule::unique('productos', 'codigo')->ignore($productoId)],
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