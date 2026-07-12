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
        Schema::create('detallepago', function (Blueprint $table) {
            $table->char('id_detpag', 18)->primary();
            $table->char('cantidad_items', 18)->nullable();
            $table->char('precio_unitario', 18)->nullable();
            $table->string('id_compag', 7)->index('fk_detpago_compag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallepago');
    }
};
