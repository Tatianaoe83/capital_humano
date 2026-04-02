<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\CentroCosto;
use App\Models\Direccion;
use App\Models\Division;
use App\Models\Gerencia;
use App\Models\Puesto;
use App\Models\UnidadNegocio;
use Illuminate\Database\Seeder;

class EstructuraOrganizacionalSeeder extends Seeder
{
    /**
     * Estructura de izquierda a derecha: División → Unidad de Negocio → Dirección → Gerencia → Área → Puesto
     * Datos de ejemplo basados en la imagen (CORPORATIVO).
     */
    public function run(): void
    {
        $division = Division::firstOrCreate(
            ['nombre' => 'CORPORATIVO'],
            ['activo' => true]
        );

        $unidadNegocio = UnidadNegocio::firstOrCreate(
            [
                'division_id' => $division->id,
                'nombre' => 'CORPORATIVO',
            ],
            ['activo' => true]
        );

        $direccion = Direccion::firstOrCreate(
            [
                'unidad_negocio_id' => $unidadNegocio->id,
                'nombre' => 'DIRECCIÓN GENERAL',
            ],
            ['activo' => true]
        );

        $centroCosto = CentroCosto::firstOrCreate(
            ['nombre' => 'G520 GERENCIA DE GASTOS COMPARTIDOS 2025'],
            ['activo' => true, 'unidad_negocio_id' => null]
        );

        $gerenciaFinanzas = Gerencia::firstOrCreate(
            [
                'direccion_id' => $direccion->id,
                'nombre' => 'GERENCIA DE FINANZAS',
            ],
            ['activo' => true]
        );

        // Área DIRECCIÓN GENERAL (sin gerencia - reporta directo a la Dirección)
        $areaDireccionGeneral = Area::firstOrCreate(
            [
                'direccion_id' => $direccion->id,
                'gerencia_id' => null,
                'nombre' => 'DIRECCIÓN GENERAL',
            ],
            ['activo' => true]
        );

        // Área CONTABILIDAD (bajo Gerencia de Finanzas)
        $areaContabilidad = Area::firstOrCreate(
            [
                'direccion_id' => $direccion->id,
                'gerencia_id' => $gerenciaFinanzas->id,
                'nombre' => 'CONTABILIDAD',
            ],
            ['activo' => true]
        );

        Puesto::firstOrCreate(
            ['area_id' => $areaDireccionGeneral->id, 'nombre' => 'DIRECTOR GENERAL'],
            ['activo' => true]
        );

        Puesto::firstOrCreate(
            ['area_id' => $areaDireccionGeneral->id, 'nombre' => 'ASISTENTE DE DIRECCIÓN GENERAL'],
            ['activo' => true]
        );

        Puesto::firstOrCreate(
            ['area_id' => $areaContabilidad->id, 'nombre' => 'AUXILIAR CONTABLE'],
            ['activo' => true]
        );

        $centroCosto->areas()->syncWithoutDetaching([
            $areaDireccionGeneral->id,
            $areaContabilidad->id,
        ]);
    }
}
