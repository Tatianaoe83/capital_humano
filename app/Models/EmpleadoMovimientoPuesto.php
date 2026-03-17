<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoMovimientoPuesto extends Model
{
    use HasFactory;

    protected $table = 'empleado_movimientos_puesto';

    protected $fillable = ['empleado_id', 'puesto_id', 'fecha_movimiento', 'observaciones'];

    protected $casts = [
        'fecha_movimiento' => 'date',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }
}
