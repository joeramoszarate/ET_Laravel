<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table = 'destino';
    protected $primaryKey = 'id_destino';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = true;

    protected $fillable = [
        'id_destino',
        'nombre',
        'descripcion',
        'categoria',
        'temperatura_prom',
        'imagen_url',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'id_destino', 'id_destino');
    }
}
