<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('productos')){

            exit(0);

        } else {

            Schema::create('productos', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('idcategoria')->unsigned();
                $table->string('codigo',50)->nullable();
                $table->string('nombre',100)->unique();
                $table->decimal('precio_venta',11,2);
                $table->integer('stock');
                $table->boolean('condicion')->default(1);
                $table->string('imagen');
                $table->timestamps();
    
                $table->foreign('idcategoria')->references('id')->on('categorias');
            });

        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
