<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'nombre_empresa','email_contacto','telefono','direccion','descripcion',
        'moneda','zona_horaria','idioma',
        'notif_email','notif_sms','confirm_reserva','recordatorio_pago','emails_marketing',
        'stripe_public','stripe_secret','stripe_enabled','paypal_enabled',
        'logo_url','favicon_url','hero_titulo','hero_subtitulo','hero_imagen_url',
        'banner1_imagen','banner1_titulo','banner1_link',
        'banner2_imagen','banner2_titulo','banner2_link',
        'seccion_nosotros_titulo','seccion_nosotros_texto','seccion_nosotros_imagen',
        'color_primario','color_secundario','whatsapp',
        'facebook_url','instagram_url','slogan',
    ];
}
