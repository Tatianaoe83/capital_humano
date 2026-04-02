<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = ['direccion_id', 'gerencia_id', 'nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

    public function gerencia(): BelongsTo
    {
        return $this->belongsTo(Gerencia::class, 'gerencia_id');
    }

    public function puestos(): HasMany
    {
        return $this->hasMany(Puesto::class, 'area_id');
    }

    public function centrosCostos(): BelongsToMany
    {
        return $this->belongsToMany(CentroCosto::class, 'area_centro_costo')->withTimestamps();
    }
}
