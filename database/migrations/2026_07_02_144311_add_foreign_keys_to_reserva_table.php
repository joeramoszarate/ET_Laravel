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
        Schema::table('reserva', function (Blueprint $table) {
            $table->foreign(['id_cliente'], 'FK_Reserva_Cliente')->references(['id_cliente'])->on('cliente')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_usuario'], 'FK_Reserva_Usuario')->references(['id_usuario'])->on('usuario')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserva', function (Blueprint $table) {
            $table->dropForeign('FK_Reserva_Cliente');
            $table->dropForeign('FK_Reserva_Usuario');
        });
    }
};
