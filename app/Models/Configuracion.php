<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'nombre_empresa',
        'email_contacto',
        'telefono',
        'direccion',
        'descripcion',
        'moneda',
        'zona_horaria',
        'idioma',
        'notif_email',
        'notif_sms',
        'confirm_reserva',
        'recordatorio_pago',
        'emails_marketing',
        'stripe_public',
        'stripe_secret',
        'stripe_enabled',
        'paypal_enabled',
    ];
}
