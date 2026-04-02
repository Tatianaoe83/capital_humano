<?php

use App\Models\CentroCosto;
use App\Models\Direccion;
use App\Models\UnidadNegocio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('centros_costos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unidad_negocio_id')->constrained('unidades_negocio')->cascadeOnDelete();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::table('direcciones', function (Blueprint $table) {
            $table->foreignId('centro_costo_id')
                ->nullable()
                ->after('unidad_negocio_id')
                ->constrained('centros_costos')
                ->restrictOnDelete();
        });

        $centrosPorUnidad = [];

        Direccion::query()
            ->select(['id', 'unidad_negocio_id', 'activo'])
            ->orderBy('id')
            ->each(function (Direccion $direccion) use (&$centrosPorUnidad) {
                $unidadNegocioId = $direccion->unidad_negocio_id;

                if (! isset($centrosPorUnidad[$unidadNegocioId])) {
                    $unidad = UnidadNegocio::find($unidadNegocioId);

                    if (! $unidad) {
                        return;
                    }

                    $centro = CentroCosto::create([
                        'unidad_negocio_id' => $unidad->id,
                        'nombre' => $unidad->nombre,
                        'activo' => $unidad->activo,
                    ]);

                    $centrosPorUnidad[$unidadNegocioId] = $centro->id;
                }

                $direccion->update([
                    'centro_costo_id' => $centrosPorUnidad[$unidadNegocioId],
                ]);
            });
    }

    public function down(): void
    {
        Schema::table('direcciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('centro_costo_id');
        });

        Schema::dropIfExists('centros_costos');
    }
};
