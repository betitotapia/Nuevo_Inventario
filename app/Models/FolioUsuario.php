<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FolioUsuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'modulo',
        'anio',
        'ultimo_numero',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}