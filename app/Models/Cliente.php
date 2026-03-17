<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre_comercial',
        'razon_social',
        'rfc',
        'tipo_cliente',
        'telefono',
        'email',
        'direccion',
        'contacto_principal',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrivado($query)
    {
        return $query->whereIn('tipo_cliente', ['privado', 'mixto']);
    }

    public function scopeIntegral($query)
    {
        return $query->whereIn('tipo_cliente', ['integral', 'mixto']);
    }
}