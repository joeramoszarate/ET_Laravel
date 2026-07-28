<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    protected $table = 'paquetes';
    protected $primaryKey = 'id_paquete';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_paquete',
        'nombre_paquete',
        'descripcion',
        'id_tippaq',
        'imagen_url',
    ];
}
