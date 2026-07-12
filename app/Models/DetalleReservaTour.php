<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleReservaTour extends Model
{
    protected $table = 'detallereservatour';
    protected $primaryKey = 'id_numreto';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_numreto',
        'id_tour',
        'cantidad_persona',
        'precio_unitario',
        'id_reserva',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'id_tour', 'id_tour');
    }
}
