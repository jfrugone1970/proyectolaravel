<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    //
    protected $table = 'pagos';
    
    protected $fillable = [
        'tipo_pago',
        'idcliente',
        'idbanco',
        'idtarjeta',
        'valor'
    ];

    /*el pago del cliente*/
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    /*la tarjeta a que banco se refiere*/
    public function banco()
    {
        return $this->belongsTo('App\Banco');
    }

    /*el pago que se hace con tarjeta*/
    public function tarjeta()
    {
        return $this->belongsTo('App\Tarjeta');
    } 
}
