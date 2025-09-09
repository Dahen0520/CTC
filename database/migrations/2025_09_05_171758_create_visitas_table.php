<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_visita_id')->constrained('tipo_visitas')->onDelete('cascade');
            
            // Columna para guardar el precio de la visita
            // '8, 2' significa que puede guardar hasta 8 dígitos en total, con 2 decimales. Ej: 123456.78
            $table->decimal('precio', 8, 2);

            $table->date('fecha');
            $table->string('numero_identidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitas');
    }
};

