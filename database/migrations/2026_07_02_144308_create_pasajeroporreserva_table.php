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
        Schema::create('pasajeroporreserva', function (Blueprint $table) {
            $table->string('num_paxres', 7)->primary();
            $table->string('id_pax', 7)->index('fk_paxres_pax');
            $table->string('id_reserva', 7)->index('fk_paxres_reserva');
            $table->integer('asiento')->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeroporreserva');
    }
};
