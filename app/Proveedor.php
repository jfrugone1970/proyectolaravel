<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    protected $table = 'proveedores';

    protected $fillable=['nombre','tipo_documento','num_documento','direccion','telefono','email'];
}
