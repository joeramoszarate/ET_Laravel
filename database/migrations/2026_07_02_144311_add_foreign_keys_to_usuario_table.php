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
        Schema::table('usuario', function (Blueprint $table) {
            $table->foreign(['id_tipdoc'], 'FK_Usuario_TipoDoc')->references(['id_tipdoc'])->on('tipodocumento')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_tiprol'], 'FK_Usuario_TipoRol')->references(['id_tiprol'])->on('tiporol')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropForeign('FK_Usuario_TipoDoc');
            $table->dropForeign('FK_Usuario_TipoRol');
        });
    }
};
