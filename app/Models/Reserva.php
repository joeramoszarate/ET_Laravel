<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_reserva',
        'precio_publicado',
        'estado',
        'fecha_reserva',
        'observaciones',
        'id_usuario',
        'id_cliente',
    ];

    protected $casts = [
        'fecha_reserva' => 'datetime',
        'precio_publicado' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleReservaTour::class, 'id_reserva', 'id_reserva');
    }

    public function comprobantes()
    {
        return $this->hasMany(ComprobantePago::class, 'id_reserva', 'id_reserva');
    }
}
