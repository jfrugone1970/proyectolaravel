<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesBancoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('clientes_banco')){

            exit(0);

        } else{
               Schema::create('clientes_banco', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('idcliente')->unsigned();
                    $table->foreign('idcliente')->references('id')->on('clientes')->onDelete('cascade');
                    $table->integer('idbanco')->unsigned();
                    $table->foreign('idbanco')->references('id')->on('bancos')->onDelete('cascade');
                    $table->string('banco',50)->nullable();
                    $table->string('tipo_cta',10);
                    $table->string('cuenta',50)->nullable();
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
        Schema::dropIfExists('clientes_banco');
    }
}
