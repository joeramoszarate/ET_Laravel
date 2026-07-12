<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprobantePago extends Model
{
    protected $table = 'comprobantepago';
    protected $primaryKey = 'id_compag';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_compag',
        'num_serie',
        'observaciones',
        'id_reserva',
        'num_correlativo',
        'fecha_emision',
        'monto_facturado',
        'id_metpago',
        'id_tipcom',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
        'monto_facturado' => 'decimal:2',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }
}
