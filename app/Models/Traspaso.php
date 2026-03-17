<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Traspaso extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'fecha_traspaso',
        'almacen_origen_id',
        'almacen_destino_id',
        'estatus',
        'observaciones',
        'created_by',
        'updated_by',
        'cancelled_by',
        'cancelled_at',
        'cancel_reason',
    ];

    protected $casts = [
        'fecha_traspaso' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function origen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_origen_id');
    }

    public function destino(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_destino_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(TraspasoDetalle::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}