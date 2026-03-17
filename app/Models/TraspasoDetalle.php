<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TraspasoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'traspaso_id',
        'producto_id',
        'lote',
        'caducidad',
        'ubicacion_origen',
        'ubicacion_destino',
        'cantidad',
        'costo_unitario',
    ];

    protected $casts = [
        'caducidad' => 'date',
        'cantidad' => 'decimal:3',
        'costo_unitario' => 'decimal:4',
    ];

    public function traspaso(): BelongsTo
    {
        return $this->belongsTo(Traspaso::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}