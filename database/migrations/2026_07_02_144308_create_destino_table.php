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
        Schema::create('destino', function (Blueprint $table) {
            $table->string('id_destino', 7)->primary();
            $table->char('nombre', 18);
            $table->char('descripcion', 18);
            $table->char('categoria', 18);
            $table->char('temperatura_prom', 18)->nullable();
            $table->string('imagen_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destino');
    }
};
