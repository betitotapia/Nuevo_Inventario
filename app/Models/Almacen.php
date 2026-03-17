<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacens';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_almacen',
        'parent_id',
        'responsable_user_id',
        'permite_privado',
        'permite_integral',
        'is_active',
    ];

    protected $casts = [
        'permite_privado' => 'boolean',
        'permite_integral' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Almacen::class, 'parent_id')->orderBy('nombre');
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'almacen_user')
            ->withPivot(['puede_consultar', 'puede_operar'])
            ->withTimestamps();
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->codigo} - {$this->nombre}";
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