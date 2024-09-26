<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaTarjeta extends Model
{
    use HasFactory;

    protected $table = 'rccliente.categoriatarjeta';
    protected $primaryKey = 'codigo_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function tarjetasPuntos()
    {
        return $this->hasMany(TarjetaPuntos::class, 'codigo_categoria');
    }
}
