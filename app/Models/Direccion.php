<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';

    protected $fillable = ['unidad_negocio_id', 'nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function unidadNegocio(): BelongsTo
    {
        return $this->belongsTo(UnidadNegocio::class, 'unidad_negocio_id');
    }

    public function gerencias(): HasMany
    {
        return $this->hasMany(Gerencia::class, 'direccion_id');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'direccion_id');
    }
}
