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
        Schema::create('usuario', function (Blueprint $table) {
            $table->char('id_tiprol', 18)->index('fk_usuario_tiporol');
            $table->char('id_usuario', 18)->primary();
            $table->char('nombre', 18)->nullable();
            $table->char('correo', 18)->nullable();
            $table->char('contraseña', 18)->nullable();
            $table->char('telefono', 18)->nullable();
            $table->char('direccion', 18)->nullable();
            $table->char('apellidos', 18)->nullable();
            $table->string('id_tipdoc', 7)->index('fk_usuario_tipodoc');
            $table->char('nro_documento', 18)->nullable();
            $table->char('fecha_registro', 18)->nullable();
            $table->char('estado', 18)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
