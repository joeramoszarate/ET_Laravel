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
        Schema::table('pasajeroporreserva', function (Blueprint $table) {
            $table->foreign(['id_pax'], 'FK_PaxRes_Pax')->references(['id_pax'])->on('pasajeros')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_reserva'], 'FK_PaxRes_Reserva')->references(['id_reserva'])->on('reserva')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajeroporreserva', function (Blueprint $table) {
            $table->dropForeign('FK_PaxRes_Pax');
            $table->dropForeign('FK_PaxRes_Reserva');
        });
    }
};
