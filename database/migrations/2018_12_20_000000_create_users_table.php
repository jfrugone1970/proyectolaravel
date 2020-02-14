<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')){

            exit(0);

        } else {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',100);
                $table->string('tipo_documento',20)->nullable();
                $table->string('num_documento',20)->nullable();
                $table->string('direccion',70)->nullable();
                $table->string('telefono',20)->nullable();
                $table->string('email',50)->nullable();
                $table->string('usuario')->unique();
                $table->string('password');
                $table->boolean('condicion')->default(1);
                $table->integer('idrol')->unsigned();
                $table->foreign('idrol')->references('id')->on('roles');
                $table->string('imagen');
                $table->rememberToken(); 
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
        Schema::dropIfExists('users');
    }
}
