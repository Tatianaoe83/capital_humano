<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpleadoMovimientoAltaBaja extends Model
{
    use HasFactory;

    protected $table = 'empleado_movimientos_alta_baja';

    const TIPO_ALTA = 'ALTA';
    const TIPO_BAJA = 'BAJA';
    const TIPO_REINGRESO = 'REINGRESO';

    protected $fillable = ['empleado_id', 'tipo', 'fecha', 'motivo', 'observaciones'];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public static function tipos(): array
    {
        return [self::TIPO_ALTA, self::TIPO_BAJA, self::TIPO_REINGRESO];
    }
}
