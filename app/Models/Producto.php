<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'sku',
        'descripcion',
        'categoria_producto_id',
        'unidad_medida_id',
        'maneja_lote',
        'maneja_caducidad',
        'precio_base',
        'is_active',
    ];

    protected $casts = [
        'maneja_lote' => 'boolean',
        'maneja_caducidad' => 'boolean',
        'is_active' => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_producto_id');
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadMedida::class, 'unidad_medida_id');
    }

    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }

    public function existencias(): HasMany
{
    return $this->hasMany(Existencia::class);
}

public function movimientos(): HasMany
{
    return $this->hasMany(InventarioMovimiento::class);
}
}