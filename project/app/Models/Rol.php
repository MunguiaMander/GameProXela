<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    protected $table = 'rcempleado.rol';
    protected $primaryKey = 'codigo_rol';
    public $timestamps = false;

    protected $fillable = [
        'nombre'
    ];

    public function empleado()
    {
        return $this->hasMany(Empleado::class, 'codigo_rol');
    }

}
