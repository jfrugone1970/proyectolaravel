<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('proveedores')){

            exit(0);

        } else {
            Schema::create('proveedores', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',100)->unique();
                $table->string('tipo_documento',20)->nullable();
                $table->string('num_documento',20)->nullable();
                $table->string('direccion',70)->nullable();
                $table->string('telefono',20)->nullable();
                $table->string('email',50)->nullable();
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
        Schema::dropIfExists('proveedores');
    }
}
