<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->string("name",1000);
            $table->string("description",1000);
            $table->integer("quantity")->unsigned();//entero sin signo
            $table->integer("status");
            $table->integer("seller_id")->unsigned();//entero sin signo
            //seller_id deberia apuntar a sellers pero como ya hemos dicho un seller es un user por lo
            //tanto en on: se pasa "users"
            $table->foreign("seller_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
