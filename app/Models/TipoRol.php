<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoRol extends Model
{
    protected $table = 'tiporol';
    protected $primaryKey = 'id_tiprol';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_tiprol',
        'descripcion',
    ];
}
