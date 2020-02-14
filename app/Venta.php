<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    protected $table = 'ventas';
    protected $fillable =[
        'idcliente',
        'idusuario',
        'tipo_identificacion',
        'num_venta',
        'fecha_venta',
        'impuesto',
        'total',
        'estado'
    ];
}
