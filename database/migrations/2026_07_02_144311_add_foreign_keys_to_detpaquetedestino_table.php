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
        Schema::table('detpaquetedestino', function (Blueprint $table) {
            $table->foreign(['id_destino'], 'FK_DetPaqDest_Destino')->references(['id_destino'])->on('destino')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_paquete'], 'FK_DetPaqDest_Paquete')->references(['id_paquete'])->on('paquetes')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detpaquetedestino', function (Blueprint $table) {
            $table->dropForeign('FK_DetPaqDest_Destino');
            $table->dropForeign('FK_DetPaqDest_Paquete');
        });
    }
};
