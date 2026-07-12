<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            if (!Schema::hasColumn('paquetes', 'imagen_url')) {
                $table->string('imagen_url')->nullable()->after('descripcion');
            }
        });
    }

    public function down()
    {
        Schema::table('paquetes', function (Blueprint $table) {
            if (Schema::hasColumn('paquetes', 'imagen_url')) {
                $table->dropColumn('imagen_url');
            }
        });
    }
};
