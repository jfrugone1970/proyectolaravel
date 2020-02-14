<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('detalle_compras')){

            exit(0);

        } else {
            Schema::create('detalle_compras', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('idcompra')->unsigned();
                $table->foreign('idcompra')->references('id')->on('compras')->onDelete('cascade');
                $table->integer('idproducto')->unsigned();
                $table->foreign('idproducto')->references('id')->on('productos');
                $table->integer('cantidad');
                $table->decimal('precio', 11, 2);
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
        Schema::dropIfExists('detalle_compras');
    }
}
