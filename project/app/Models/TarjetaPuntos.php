<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarjetaPuntos extends Model
{
    use HasFactory;
    protected $table = 'rccliente.tarjetapuntos';
    protected $primaryKey = 'nit_cliente';
    protected $keyType = 'string';
    public $incrementig = false;
    public $timestamps = false;

    protected $fillable = [
        'nit_cliente',
        'codigo_categoria',
        'total_gastado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class,'nit_cliente');
    }

    public function categoriaTarjeta()
    {
        return $this->belongsTo(CategoriaTarjeta::class,'codigo_categoria');
    }

}
