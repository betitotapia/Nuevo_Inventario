<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Existencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'almacen_id',
        'producto_id',
        'lote',
        'caducidad',
        'ubicacion',
        'cantidad',
        'costo_promedio',
    ];

    protected $casts = [
        'caducidad' => 'date',
        'cantidad' => 'decimal:3',
        'costo_promedio' => 'decimal:4',
    ];

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}