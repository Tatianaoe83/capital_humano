<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado_movimientos_alta_baja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->string('tipo'); // ALTA, BAJA, REINGRESO
            $table->date('fecha');
            $table->string('motivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_movimientos_alta_baja');
    }
};
