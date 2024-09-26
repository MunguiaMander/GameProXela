<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'rcpersonal.detalleventa';
    protected $primaryKey = 'codigo_detalle_venta';
    public $timestamps = false;

    protected $fillable = [
        'codigo_venta',
        'producto',
        'cantidad'
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'codigo_venta');
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'codigo_producto');
    }

}
