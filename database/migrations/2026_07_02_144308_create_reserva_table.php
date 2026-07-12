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
        Schema::create('reserva', function (Blueprint $table) {
            $table->string('id_reserva', 7)->primary();
            $table->decimal('precio_publicado', 10);
            $table->char('estado', 1);
            $table->dateTime('fecha_reserva');
            $table->text('observaciones')->nullable();
            $table->char('id_usuario', 18)->index('fk_reserva_usuario');
            $table->string('id_cliente', 7)->index('fk_reserva_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
