<?php

use App\Models\Direccion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('area_centro_costo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->constrained('areas')->cascadeOnDelete();
            $table->foreignId('centro_costo_id')->constrained('centros_costos')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['area_id', 'centro_costo_id']);
        });

        Direccion::query()
            ->whereNotNull('centro_costo_id')
            ->with(['areas', 'gerencias.areas'])
            ->each(function (Direccion $direccion) {
                $ids = $direccion->areas->pluck('id');
                foreach ($direccion->gerencias as $gerencia) {
                    $ids = $ids->merge($gerencia->areas->pluck('id'));
                }
                $now = now();
                foreach ($ids->unique()->values() as $areaId) {
                    DB::table('area_centro_costo')->insertOrIgnore([
                        'area_id' => $areaId,
                        'centro_costo_id' => $direccion->centro_costo_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            });

        Schema::table('direcciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('centro_costo_id');
        });
    }

    public function down(): void
    {
        Schema::table('direcciones', function (Blueprint $table) {
            $table->foreignId('centro_costo_id')
                ->nullable()
                ->after('unidad_negocio_id')
                ->constrained('centros_costos')
                ->restrictOnDelete();
        });

        $rows = DB::table('area_centro_costo')
            ->select('area_id', 'centro_costo_id')
            ->orderBy('id')
            ->get()
            ->groupBy('area_id');

        foreach ($rows as $areaId => $group) {
            $area = DB::table('areas')->where('id', $areaId)->first();
            if (! $area) {
                continue;
            }
            $direccionId = $area->direccion_id;
            $centroId = $group->first()->centro_costo_id;
            DB::table('direcciones')
                ->where('id', $direccionId)
                ->whereNull('centro_costo_id')
                ->update(['centro_costo_id' => $centroId]);
        }

        Schema::dropIfExists('area_centro_costo');
    }
};
