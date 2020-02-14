<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (schema::hasTable('bancos')){

            exit(0);

        } else{
       
            Schema::create('bancos', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre',50)->nullable();
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
        Schema::dropIfExists('bancos');
    }
}
