<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('tarjeta')){

            exit(0);

        } else{
            Schema::create('tarjeta', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',50);
                $table->string('descripcion',50);
                $table->string('externa',12);
                $table->integer('idbancos')->unsigned();
                $table->foreign('idbancos')->references('id')->on('bancos');
                $table->boolean('condicion')->default(1);
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
        Schema::dropIfExists('tarjeta');
    }
}
