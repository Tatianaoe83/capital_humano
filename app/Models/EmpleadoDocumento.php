<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EmpleadoDocumento extends Model
{
    protected $table = 'empleado_documentos';

    protected $fillable = [
        'empleado_id',
        'nombre',
        'nombre_archivo',
        'ruta',
        'mime_type',
        'tamano',
    ];

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function getRutaCompletaAttribute(): string
    {
        return storage_path('app/'.$this->ruta);
    }

    public function existeArchivo(): bool
    {
        return Storage::disk('local')->exists($this->ruta);
    }
}
