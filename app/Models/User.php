<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo_operacion',
        'clave_remision',
        'almacen_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function almacenes(): BelongsToMany
    {
        return $this->belongsToMany(Almacen::class, 'almacen_user')
            ->withPivot(['puede_consultar', 'puede_operar'])
            ->withTimestamps();
    }

    public function folios(): HasMany
    {
        return $this->hasMany(FolioUsuario::class);
    }

    public function esPrivado(): bool
    {
        return in_array($this->tipo_operacion, ['privado', 'ambos'], true);
    }

    public function esIntegral(): bool
    {
        return in_array($this->tipo_operacion, ['integral', 'ambos'], true);
    }

    public function getRolPrincipalAttribute(): ?string
    {
        return $this->roles->first()?->name;
    }
}