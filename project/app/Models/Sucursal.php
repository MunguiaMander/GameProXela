<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'rcempleado.sucursal';
    protected $primeryKey = 'codigo_sucursal';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function empleado()
    {
        return $this->hasMany(Empleado::class,'codigo_sucursal');
    }
    
    public function bodega()
    {
        return $this->hasMany(Bodega::class,'sucursal');
    }
    
    public function estanteria()
    {
        return $this->hasMany(Estanteria::class,'sucursal');
    }

}
