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
        Schema::create('pasajeros', function (Blueprint $table) {
            $table->string('id_pax', 7)->primary();
            $table->string('nombre', 50);
            $table->char('nro_documento', 18);
            $table->char('telefono', 15)->nullable();
            $table->string('id_tippax', 7)->index('fk_pasajeros_tippax');
            $table->string('nacionalidad', 50);
            $table->string('id_tipdoc', 7)->index('fk_pasajeros_tipdoc');
            $table->string('apellidos', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasajeros');
    }
};
