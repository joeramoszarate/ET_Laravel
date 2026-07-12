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
        Schema::create('tour', function (Blueprint $table) {
            $table->string('id_tour', 7)->primary();
            $table->integer('duracion_dias')->nullable();
            $table->char('estado', 18);
            $table->string('id_destino', 7)->index('fk_tour_destino');
            $table->string('nombre_tour', 150);
            $table->text('descripcion');
            $table->decimal('precio', 10);
            $table->string('ubicacion_exacta', 150);
            $table->string('imagen_url');
            $table->string('id_catto', 7)->index('fk_tour_cattour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour');
    }
};
