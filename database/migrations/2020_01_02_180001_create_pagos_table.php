<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('pagos')){

            exit(0);

        } else{
            Schema::create('pagos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('factura',10);
                $table->string('tipo_pago',10);
                $table->integer('idcliente')->unsigned();
                $table->foreign('idcliente')->references('id')->on('clientes');
                $table->string('nombre',100)->nullable();
                $table->integer('idbanco')->unsigned();
                $table->foreign('idbanco')->references('id')->on('bancos');
                $table->string('nombre_banco',50)->nullable();
                $table->integer('idtarjeta')->unsigned();
                $table->foreign('idtarjeta')->references('id')->on('tarjeta');
                $table->string('nombre_tarjeta',50)->nullable();
                $table->integer('valor');
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
        Schema::dropIfExists('pagos');
    }
}
