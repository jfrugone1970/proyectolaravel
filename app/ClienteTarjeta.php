<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteTarjeta extends Model
{
    //
    protected $table = 'clientes_tarjetas';
    
    protected $fillable = [
        'idcliente', 
        'idtarjeta',
        'tarjeta',
        'idbanco',
        'num_tarjeta',
        'estado'
     ];

     /*es el cliente que se asocia*/
     public function cliente()
     {
         return $this->belongsTo('App\Cliente');
     }

     /*es la tarjeta que se asocia*/
     public function tarjeta()
     {
         return $this->belongsTo('App\Tarjeta');
     }

     /*es el banco que se asocia*/
     public function banco()
     {
         return $this->belongsTo('App\Banco');
     }
}
