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
        Schema::create('detallereservapaquete', function (Blueprint $table) {
            $table->char('id_numrepa', 18)->primary();
            $table->string('id_paquete', 7)->index('fk_detrespaq_paquete');
            $table->string('id_reserva', 7)->index('fk_detrespaq_reserva');
            $table->char('cantifdad_persona', 18)->nullable();
            $table->char('precio_unitario', 18)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallereservapaquete');
    }
};
