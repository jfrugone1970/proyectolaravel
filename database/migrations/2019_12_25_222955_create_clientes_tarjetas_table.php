<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('clientes_tarjetas')){

            exit(0);

        } else{
                 Schema::create('clientes_tarjetas', function (Blueprint $table){
                     $table->increments('id');
                     $table->integer('idcliente')->unsigned();
                     $table->foreign('idcliente')->references('id')->on('clientes')->onDelete('cascade');
                     $table->integer('idtarjeta')->unsigned();
                     $table->foreign('idtarjeta')->references('id')->on('tarjeta')->onDelete('cascade');
                     $table->string('tarjeta', 50)->nullable();
                     $table->integer('idbanco')->unsigned();
                     $table->foreign('idbanco')->references('id')->on('bancos')->onDelete('cascade');
                     $table->string('ntarjeta', 80)->nullable();
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
        Schema::dropIfExists('clientes_tarjetas');
    }
}
