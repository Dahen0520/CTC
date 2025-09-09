<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_visitas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2)->default(0); 
            $table->enum('estado', ['activo', 'inactivo'])->default('activo'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_visitas');
    }
};
