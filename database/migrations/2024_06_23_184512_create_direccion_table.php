<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionTable extends Migration
{
    public function up()
    {
        Schema::create('direccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->string('calle');
            $table->string('numero_exterior');
            $table->string('numero_interior')->nullable();
            $table->string('colonia');
            $table->string('cp');

            $table->foreign('persona_id')->references('id')->on('persona');
        });
    }

    public function down()
    {
        Schema::dropIfExists('direccion');
    }
}
