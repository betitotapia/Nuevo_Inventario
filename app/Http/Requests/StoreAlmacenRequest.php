<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlmacenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('crear_almacenes');
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', 'unique:almacens,codigo'],
            'nombre' => ['required', 'string', 'max:150'],
            'tipo_almacen' => ['required', Rule::in(['padre', 'hijo', 'tecnico', 'general'])],
            'parent_id' => ['nullable', 'exists:almacens,id'],
            'responsable_user_id' => ['nullable', 'exists:users,id'],
            'permite_privado' => ['nullable', 'boolean'],
            'permite_integral' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $tipo = $this->input('tipo_almacen');
            $parentId = $this->input('parent_id');

            if ($tipo === 'hijo' && empty($parentId)) {
                $validator->errors()->add('parent_id', 'Un almacén hijo debe tener almacén padre.');
            }

            if (in_array($tipo, ['padre', 'tecnico', 'general'], true) && !empty($parentId)) {
                $validator->errors()->add('parent_id', 'Este tipo de almacén no debe tener almacén padre.');
            }
        });
    }
}