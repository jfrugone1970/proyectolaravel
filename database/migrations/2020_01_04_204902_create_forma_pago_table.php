<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormaPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('forma_pago')){

            exit(0);

        } else {

            Schema::create('forma_pago', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',8)->unique();
                $table->string('descripcion',100)->nullable();
                //$table->timestamps();
            });
    
            DB::table('forma_pago')->insert(array('id'=>'1','nombre'=>'Efectivo','descripcion'=>'Ventas en efectivo'));
            DB::table('forma_pago')->insert(array('id'=>'2','nombre'=>'Cheque','descripcion'=>'Ventas en cheque'));
            DB::table('forma_pago')->insert(array('id'=>'3','nombre'=>'Tarjeta','descripcion'=>'Ventas con tarjeta'));

        }
        
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forma_pago');
    }
}
