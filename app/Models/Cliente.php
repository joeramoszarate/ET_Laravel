<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'nombre',
        'apellidos',
        'nro_documento',
        'correo',
        'contraseña',
        'nacionalidad',
        'id_tipdoc',
        'telefono',
        'descripcion',
        'foto_perfil',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_cliente', 'id_cliente');
    }

    public function getFechaRegistroAttribute()
    {
        $primeraReserva = $this->reservas()->orderBy('fecha_reserva')->first();
        return $primeraReserva ? $primeraReserva->fecha_reserva->format('d/m/Y') : 'N/A';
    }
}
