<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('centros_costos', function (Blueprint $table) {
            $table->dropForeign(['unidad_negocio_id']);
        });

        DB::statement('ALTER TABLE centros_costos MODIFY unidad_negocio_id BIGINT UNSIGNED NULL');

        Schema::table('centros_costos', function (Blueprint $table) {
            $table->foreign('unidad_negocio_id')
                ->references('id')
                ->on('unidades_negocio')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        DB::table('centros_costos')->whereNull('unidad_negocio_id')->update(['unidad_negocio_id' => DB::table('unidades_negocio')->value('id')]);

        Schema::table('centros_costos', function (Blueprint $table) {
            $table->dropForeign(['unidad_negocio_id']);
        });

        DB::statement('ALTER TABLE centros_costos MODIFY unidad_negocio_id BIGINT UNSIGNED NOT NULL');

        Schema::table('centros_costos', function (Blueprint $table) {
            $table->foreign('unidad_negocio_id')
                ->references('id')
                ->on('unidades_negocio')
                ->cascadeOnDelete();
        });
    }
};
