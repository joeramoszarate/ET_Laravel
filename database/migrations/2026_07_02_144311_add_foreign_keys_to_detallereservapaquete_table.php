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
        Schema::table('detallereservapaquete', function (Blueprint $table) {
            $table->foreign(['id_paquete'], 'FK_DetResPaq_Paquete')->references(['id_paquete'])->on('paquetes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_reserva'], 'FK_DetResPaq_Reserva')->references(['id_reserva'])->on('reserva')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallereservapaquete', function (Blueprint $table) {
            $table->dropForeign('FK_DetResPaq_Paquete');
            $table->dropForeign('FK_DetResPaq_Reserva');
        });
    }
};
