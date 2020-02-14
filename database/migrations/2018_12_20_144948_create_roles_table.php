<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('roles')){

            exit(0);

        } else {

            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',30)->unique();
                $table->string('descripcion',100)->nullable();
                $table->boolean('condicion')->default(1);
                //$table->timestamps();
            });
    
            DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador','descripcion'=>'Administrador'));
            DB::table('roles')->insert(array('id'=>'2','nombre'=>'Vendedor','descripcion'=>'Vendedor'));
            DB::table('roles')->insert(array('id'=>'3','nombre'=>'Comprador','descripcion'=>'Comprador'));

        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
