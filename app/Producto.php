<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table = 'productos';
    
    protected $fillable = ['idcategoria','codigo','nombre','precio_venta','stock','condicion','imagen'];
    
    public function categoria(){

        return $this->belongsTo("App\Categoria");
    }
}