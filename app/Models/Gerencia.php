<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gerencia extends Model
{
    use HasFactory;

    protected $table = 'gerencias';

    protected $fillable = ['direccion_id', 'nombre', 'activo'];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

    public function areas(): HasMany
    {
        return $this->hasMany(Area::class, 'gerencia_id');
    }
}
