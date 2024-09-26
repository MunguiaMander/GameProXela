<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'rccliente.cliente';
    protected $primaryKey ='nit_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nit_cliente',
        'nombre',
        'direccion',
        'no_puntos'
    ];

    public function tarjetaPuntos()
    {
        return $this->hasOne(TarjetaPuntos::class, 'nit_cliente');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'nit_cliente');
    }
    
}
