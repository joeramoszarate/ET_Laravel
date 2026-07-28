<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'caja';
    protected $primaryKey = 'id_caja';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_caja', 'fecha_apertura', 'hora_apertura', 'hora_cierre',
        'fondo_inicial', 'saldo_final', 'estado', 'id_usuario', 'observaciones',
    ];

    protected $casts = [
        'hora_apertura' => 'datetime',
        'hora_cierre'   => 'datetime',
        'fondo_inicial' => 'decimal:2',
        'saldo_final'   => 'decimal:2',
    ];

    public function movimientos()
    {
        return $this->hasMany(CajaMovimiento::class, 'id_caja', 'id_caja');
    }
}
