<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('categorias')){

            exit(0);

        } else {

            Schema::create('categorias', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',50)->unique();
                $table->string('descripcion',256)->nullable();
                $table->string('imagen');
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
        Schema::dropIfExists('categorias');
    }
}
