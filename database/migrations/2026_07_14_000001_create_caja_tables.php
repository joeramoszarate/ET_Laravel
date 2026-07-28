<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('caja', function (Blueprint $table) {
            $table->string('id_caja', 7)->primary();
            $table->date('fecha_apertura');
            $table->dateTime('hora_apertura');
            $table->dateTime('hora_cierre')->nullable();
            $table->decimal('fondo_inicial', 10, 2)->default(0);
            $table->decimal('saldo_final', 10, 2)->nullable();
            $table->enum('estado', ['abierta', 'cerrada'])->default('abierta');
            $table->char('id_usuario', 18);
            $table->text('observaciones')->nullable();
        });

        Schema::create('caja_movimiento', function (Blueprint $table) {
            $table->string('id_movimiento', 7)->primary();
            $table->string('id_caja', 7);
            $table->time('hora');
            $table->string('concepto', 200);
            $table->string('metodo_pago', 30)->default('Efectivo');
            $table->enum('tipo', ['ingreso', 'egreso']);
            $table->decimal('monto', 10, 2);
            $table->decimal('saldo_acumulado', 10, 2);
            $table->string('id_reserva', 7)->nullable();
            $table->foreign('id_caja')->references('id_caja')->on('caja')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('caja_movimiento');
        Schema::dropIfExists('caja');
    }
};
