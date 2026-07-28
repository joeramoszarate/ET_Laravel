<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaMovimiento extends Model
{
    protected $table = 'caja_movimiento';
    protected $primaryKey = 'id_movimiento';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_movimiento', 'id_caja', 'hora', 'concepto',
        'metodo_pago', 'tipo', 'monto', 'saldo_acumulado', 'id_reserva',
    ];

    protected $casts = [
        'monto'            => 'decimal:2',
        'saldo_acumulado'  => 'decimal:2',
    ];

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja', 'id_caja');
    }
}
