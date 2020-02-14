<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteBanco extends Model
{
    //
    protected $table = 'clientes_banco';
    
    protected $fillable = [
        'idcliente', 
        'idbanco',
        'nombre_banco',
        'tipo_cta',
        'numero_cta',
        'estado'
     ];

     /*es el cliente que se asocia*/
     public function cliente()
     {
         return $this->belongsTo('App\Cliente');
     }

     /*es el banco que se asocia*/
     public function banco()
     {
         return $this->belongsTo('App\Banco');
     }

}
