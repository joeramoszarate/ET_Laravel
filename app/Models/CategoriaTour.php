<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaTour extends Model
{
    protected $table = 'categoriatour';
    protected $primaryKey = 'id_catto';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_catto',
        'descripcion',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'id_catto', 'id_catto');
    }
}
