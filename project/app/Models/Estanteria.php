<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estanteria extends Model
{
    use HasFactory;
    protected $table = 'rcpersonal.estanteria';
    public $timestamps = false;

    protected $fillable = [
        'sucursal',
        'producto',
        'cantidad',
        'no_pasillo'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }

}
