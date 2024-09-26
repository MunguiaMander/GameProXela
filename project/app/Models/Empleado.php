<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'rcempleado.empleado';
    protected $primaryKey = 'codigo_empleado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'username',
        'password',
        'no_caja',
        'codigo_sucursal',
        'codigo_rol'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'codigo_sucursal');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'codigo_rol');
    }
    
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'codigo_empleado');
    }

}
