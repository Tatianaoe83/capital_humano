<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadNegocio extends Model
{
    use HasFactory;

    protected $table = 'unidades_negocio';

    protected $fillable = ['division_id', 'nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class, 'unidad_negocio_id');
    }
}
