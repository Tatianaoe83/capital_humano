<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleado_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->string('nombre'); // Etiqueta o descripción del documento (ej. "CURP", "Acta de nacimiento")
            $table->string('nombre_archivo'); // Nombre original del archivo
            $table->string('ruta'); // Ruta en storage
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('tamano')->nullable(); // bytes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleado_documentos');
    }
};
