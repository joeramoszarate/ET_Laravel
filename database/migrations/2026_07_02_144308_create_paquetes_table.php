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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->string('id_paquete', 7)->primary();
            $table->string('nombre_paquete', 150);
            $table->char('estado', 1);
            $table->text('descripcion');
            $table->decimal('precio_base', 10);
            $table->string('id_tippaq', 7)->index('fk_paquetes_tippaq');
            $table->string('imagen_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
