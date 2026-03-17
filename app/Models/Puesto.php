<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Puesto extends Model
{
    use HasFactory;

    protected $table = 'puestos';

    protected $fillable = ['area_id', 'nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function empleados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Empleado::class, 'puesto_id');
    }
}
