<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CentroCosto extends Model
{
    use HasFactory;

    protected $table = 'centros_costos';

    protected $fillable = ['nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function unidadNegocio(): BelongsTo
    {
        return $this->belongsTo(UnidadNegocio::class, 'unidad_negocio_id');
    }

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'area_centro_costo')->withTimestamps();
    }
}
