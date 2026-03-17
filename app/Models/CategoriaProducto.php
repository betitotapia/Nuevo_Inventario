<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaProducto extends Model
{
    use HasFactory;

    protected $table = 'categoria_productos';

    protected $fillable = [
        'nombre',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'categoria_producto_id');
    }
}