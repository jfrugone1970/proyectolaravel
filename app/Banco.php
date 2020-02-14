<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'condicion'
       
    ];

}
