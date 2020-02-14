<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    //
    protected $table = 'tarjeta';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'externa',
        'idbancos',
        'condicion'
    ];

    /*la tarjeta a que banco se refiere*/
    public function banco()
    {
        return $this->belongsTo('App\Banco');
    }
}
