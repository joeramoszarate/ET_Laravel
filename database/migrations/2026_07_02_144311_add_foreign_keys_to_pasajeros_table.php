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
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->foreign(['id_tipdoc'], 'FK_Pasajeros_TipDoc')->references(['id_tipdoc'])->on('tipodocumento')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tippax'], 'FK_Pasajeros_TipPax')->references(['id_tippax'])->on('tipopasajero')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->dropForeign('FK_Pasajeros_TipDoc');
            $table->dropForeign('FK_Pasajeros_TipPax');
        });
    }
};
