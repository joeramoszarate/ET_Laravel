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
        Schema::table('detallereservatour', function (Blueprint $table) {
            $table->foreign(['id_reserva'], 'FK_DetResTour_Reserva')->references(['id_reserva'])->on('reserva')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tour'], 'FK_DetResTour_Tour')->references(['id_tour'])->on('tour')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallereservatour', function (Blueprint $table) {
            $table->dropForeign('FK_DetResTour_Reserva');
            $table->dropForeign('FK_DetResTour_Tour');
        });
    }
};
