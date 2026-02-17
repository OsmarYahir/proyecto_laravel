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
        Schema::create('conciertos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('artista', 200);
            $table->text('descripcion')->nullable();
            $table->string('ubicacion', 255);
            $table->dateTime('fecha_evento');
            $table->decimal('precio', 10, 2);
            $table->integer('capacidad_total');
            $table->integer('boletos_disponibles');
            $table->enum('status', ['activo', 'cancelado', 'agotado'])->default('activo');
            $table->string('imagen_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conciertos');
    }
};
