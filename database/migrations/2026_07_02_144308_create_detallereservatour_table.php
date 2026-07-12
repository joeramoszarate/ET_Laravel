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
        Schema::create('detallereservatour', function (Blueprint $table) {
            $table->string('id_numreto', 7)->primary();
            $table->string('id_tour', 7)->index('fk_detrestour_tour');
            $table->integer('cantidad_persona');
            $table->decimal('precio_unitario', 10)->nullable();
            $table->string('id_reserva', 7)->index('fk_detrestour_reserva');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallereservatour');
    }
};
