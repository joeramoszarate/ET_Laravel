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
        Schema::create('detpaquetedestino', function (Blueprint $table) {
            $table->char('id_detpades', 18)->primary();
            $table->string('id_paquete', 7)->index('fk_detpaqdest_paquete');
            $table->string('id_destino', 7)->index('fk_detpaqdest_destino');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detpaquetedestino');
    }
};
