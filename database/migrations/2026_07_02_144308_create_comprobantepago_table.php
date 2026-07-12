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
        Schema::create('comprobantepago', function (Blueprint $table) {
            $table->string('id_compag', 7)->primary();
            $table->char('num_serie', 18)->nullable();
            $table->text('observaciones')->nullable();
            $table->string('id_reserva', 7)->index('fk_comppago_reserva');
            $table->char('num_correlativo', 18);
            $table->dateTime('fecha_emision');
            $table->decimal('monto_facturado', 10);
            $table->string('id_metpago', 7)->index('fk_comppago_metpago');
            $table->char('id_tipcom', 5)->index('fk_comppago_tipcom');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobantepago');
    }
};
