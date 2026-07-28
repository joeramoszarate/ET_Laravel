<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'tour';
    protected $primaryKey = 'id_tour';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_tour',
        'duracion_dias',
        'estado',
        'id_destino',
        'nombre_tour',
        'descripcion',
        'precio',
        'ubicacion_exacta',
        'imagen_url',
        'id_catto',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleReservaTour::class, 'id_tour', 'id_tour');
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class, 'id_destino', 'id_destino');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaTour::class, 'id_catto', 'id_catto');
    }
}
