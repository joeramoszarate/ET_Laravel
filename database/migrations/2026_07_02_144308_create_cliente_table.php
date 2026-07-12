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
        Schema::create('cliente', function (Blueprint $table) {
            $table->string('id_cliente', 7)->primary();
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->char('nro_documento', 18);
            $table->string('correo', 100);
            $table->char('contraseña', 8);
            $table->char('nacionalidad', 18)->nullable();
            $table->string('id_tipdoc', 7)->index('fk_cliente_tipodoc');
            $table->char('telefono', 18)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
