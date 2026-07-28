<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->string('logo_url')->nullable()->after('descripcion');
            $table->string('favicon_url')->nullable()->after('logo_url');
            $table->string('hero_titulo')->nullable()->after('favicon_url');
            $table->text('hero_subtitulo')->nullable()->after('hero_titulo');
            $table->string('hero_imagen_url')->nullable()->after('hero_subtitulo');
            $table->string('banner1_imagen')->nullable()->after('hero_imagen_url');
            $table->string('banner1_titulo')->nullable()->after('banner1_imagen');
            $table->string('banner1_link')->nullable()->after('banner1_titulo');
            $table->string('banner2_imagen')->nullable()->after('banner1_link');
            $table->string('banner2_titulo')->nullable()->after('banner2_imagen');
            $table->string('banner2_link')->nullable()->after('banner2_titulo');
            $table->string('seccion_nosotros_titulo')->nullable()->after('banner2_link');
            $table->text('seccion_nosotros_texto')->nullable()->after('seccion_nosotros_titulo');
            $table->string('seccion_nosotros_imagen')->nullable()->after('seccion_nosotros_texto');
            $table->string('color_primario')->default('#1a3c6e')->after('seccion_nosotros_imagen');
            $table->string('color_secundario')->default('#f59e0b')->after('color_primario');
            $table->string('whatsapp')->nullable()->after('color_secundario');
            $table->string('facebook_url')->nullable()->after('whatsapp');
            $table->string('instagram_url')->nullable()->after('facebook_url');
            $table->string('slogan')->nullable()->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('configuraciones', function (Blueprint $table) {
            $table->dropColumn([
                'logo_url','favicon_url','hero_titulo','hero_subtitulo','hero_imagen_url',
                'banner1_imagen','banner1_titulo','banner1_link',
                'banner2_imagen','banner2_titulo','banner2_link',
                'seccion_nosotros_titulo','seccion_nosotros_texto','seccion_nosotros_imagen',
                'color_primario','color_secundario','whatsapp',
                'facebook_url','instagram_url','slogan',
            ]);
        });
    }
};
