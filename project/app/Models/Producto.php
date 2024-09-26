<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'rcpersonal.producto';
    protected $primaryKey = 'codigo_producto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'marca'
    ];

    public function bodega()
    {
        return $this->hasMany(Bodega::class, 'producto');
    }

    public function estanteria()
    {
        return $this->hasMany(Estanteria::class, 'producto');
    }

    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'producto');
    }

}
