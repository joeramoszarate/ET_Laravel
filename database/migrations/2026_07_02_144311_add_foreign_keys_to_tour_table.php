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
        Schema::table('tour', function (Blueprint $table) {
            $table->foreign(['id_catto'], 'FK_Tour_CatTour')->references(['id_catto'])->on('categoriatour')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_destino'], 'FK_Tour_Destino')->references(['id_destino'])->on('destino')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour', function (Blueprint $table) {
            $table->dropForeign('FK_Tour_CatTour');
            $table->dropForeign('FK_Tour_Destino');
        });
    }
};
