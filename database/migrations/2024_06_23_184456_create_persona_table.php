<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');  
        });
    }

    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
