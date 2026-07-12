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
        Schema::table('detallepago', function (Blueprint $table) {
            $table->foreign(['id_compag'], 'FK_DetPago_Compag')->references(['id_compag'])->on('comprobantepago')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallepago', function (Blueprint $table) {
            $table->dropForeign('FK_DetPago_Compag');
        });
    }
};
