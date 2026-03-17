<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'fecha_ingreso',
        'jefe_inmediato_id',
        'puesto_id',
        'sindicalizado',
        'tipo_prestacion',
        'ubicacion',
        'curp',
        'nss',
        'registro_patronal',
        'rfc',
        'telefono',
        'domicilio',
        'correo_personal',
        'correo_institucional',
        'estado_civil',
        'sexo',
        'hijos',
        'fecha_nacimiento',
        'personal',
        'tipo_contrato',
        'numero_contacto',
        'activo',
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_nacimiento' => 'date',
        'sindicalizado' => 'boolean',
        'activo' => 'boolean',
    ];

    public function jefeInmediato(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'jefe_inmediato_id');
    }

    public function puesto(): BelongsTo
    {
        return $this->belongsTo(Puesto::class);
    }

    public function subordinados(): HasMany
    {
        return $this->hasMany(Empleado::class, 'jefe_inmediato_id');
    }

    public function movimientosPuesto(): HasMany
    {
        return $this->hasMany(EmpleadoMovimientoPuesto::class)->orderByDesc('fecha_movimiento');
    }

    public function movimientosAltaBaja(): HasMany
    {
        return $this->hasMany(EmpleadoMovimientoAltaBaja::class)->orderByDesc('fecha');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(EmpleadoDocumento::class)->orderByDesc('created_at');
    }
}
