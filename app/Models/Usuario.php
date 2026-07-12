<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_tiprol',
        'id_usuario',
        'nombre',
        'correo',
        'contraseña',
        'telefono',
        'direccion',
        'apellidos',
        'id_tipdoc',
        'nro_documento',
        'fecha_registro',
        'estado',
    ];

    protected $hidden = [
        'contraseña',
    ];

    public function getAuthPassword(): string
    {
        return (string) $this->contraseña;
    }

    public function getAuthIdentifierName(): string
    {
        return 'correo';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->correo;
    }

    public function getRememberTokenName(): string
    {
        return '';
    }

    public function rol()
    {
        return $this->belongsTo(TipoRol::class, 'id_tiprol', 'id_tiprol');
    }
}
