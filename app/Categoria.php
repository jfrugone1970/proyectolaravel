<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $table = 'categorias';

    protected $fillable = ['nombre','descripcion','imagen','condicion'];

    public function productos(){

        return $this->hasMany("App\Producto");
   }
}
