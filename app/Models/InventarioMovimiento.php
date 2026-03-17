<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarioMovimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_movimiento',
        'tipo_movimiento',
        'almacen_id',
        'producto_id',
        'lote',
        'caducidad',
        'ubicacion',
        'cantidad',
        'costo_unitario',
        'referencia_tipo',
        'referencia_id',
        'observaciones',
        'user_id',
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'caducidad' => 'date',
        'cantidad' => 'decimal:3',
        'costo_unitario' => 'decimal:4',
    ];

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}