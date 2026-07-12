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
        Schema::table('comprobantepago', function (Blueprint $table) {
            $table->foreign(['id_metpago'], 'FK_CompPago_MetPago')->references(['id_metpago'])->on('metodopago')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_reserva'], 'FK_CompPago_Reserva')->references(['id_reserva'])->on('reserva')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tipcom'], 'FK_CompPago_TipCom')->references(['id_tipcom'])->on('tipocomprobante')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comprobantepago', function (Blueprint $table) {
            $table->dropForeign('FK_CompPago_MetPago');
            $table->dropForeign('FK_CompPago_Reserva');
            $table->dropForeign('FK_CompPago_TipCom');
        });
    }
};
