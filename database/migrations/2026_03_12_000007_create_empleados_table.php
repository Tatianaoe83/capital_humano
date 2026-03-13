<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('nombre');
            $table->date('fecha_ingreso');
            $table->foreignId('jefe_inmediato_id')->nullable()->constrained('empleados')->nullOnDelete();
            $table->boolean('sindicalizado')->default(false);
            $table->string('tipo_prestacion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('nss')->nullable();
            $table->string('registro_patronal')->nullable();
            $table->string('rfc', 13)->nullable();
            $table->string('telefono')->nullable();
            $table->text('domicilio')->nullable();
            $table->string('correo_personal')->nullable();
            $table->string('correo_institucional')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('sexo')->nullable();
            $table->unsignedTinyInteger('hijos')->default(0);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('personal')->nullable(); // FIJO / EVENTUAL
            $table->string('tipo_contrato')->nullable();
            $table->string('numero_contacto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
