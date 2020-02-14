<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('compras')){

            exit(0);

        } else {

            Schema::create('compras', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('idproveedor')->unsigned();
                $table->foreign('idproveedor')->references('id')->on('proveedores');
                $table->integer('idusuario')->unsigned();
                $table->foreign('idusuario')->references('id')->on('users');
                $table->string('tipo_identificacion', 20);
                $table->string('num_compra', 10);
                $table->dateTime('fecha_compra');
                $table->decimal('impuesto', 4, 2);
                $table->decimal('total', 11, 2);
                $table->string('estado', 20);
                $table->timestamps();
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
        Schema::dropIfExists('compras');
    }
}
