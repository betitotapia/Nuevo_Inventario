<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTraspasoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('crear_traspasos');
    }

    public function rules(): array
    {
        return [
            'almacen_origen_id' => ['required', 'exists:almacens,id'],
            'almacen_destino_id' => ['required', 'exists:almacens,id', 'different:almacen_origen_id'],
            'observaciones' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.producto_id' => ['required', 'exists:productos,id'],
            'items.*.lote' => ['nullable', 'string', 'max:80'],
            'items.*.caducidad' => ['nullable', 'date'],
            'items.*.ubicacion_origen' => ['nullable', 'string', 'max:100'],
            'items.*.ubicacion_destino' => ['nullable', 'string', 'max:100'],
            'items.*.cantidad' => ['required', 'numeric', 'gt:0'],
            'items.*.costo_unitario' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}