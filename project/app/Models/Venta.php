<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'rcpersonal.venta';
    protected $primaryKey = 'codigo_venta';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'subtotal',
        'descuento',
        'total',
        'nit_cliente',
        'codigo_empleado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'nit_cliente');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'codigo_empleado');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'codigo_venta');
    }

}
