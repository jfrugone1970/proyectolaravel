<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table='forma_pago';
    protected $fillable=['nombre','descripcion'];
    public $timestamps=false;

    
}
