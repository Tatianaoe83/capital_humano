<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado_movimientos_puesto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->foreignId('puesto_id')->constrained('puestos')->cascadeOnDelete();
            $table->date('fecha_movimiento');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_movimientos_puesto');
    }
};
