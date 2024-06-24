<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonoTable extends Migration
{
    public function up()
    {
        Schema::create('telefono', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->string('telefono', 50);

            $table->foreign('persona_id')->references('id')->on('persona');
        });
    }

    public function down()
    {
        Schema::dropIfExists('telefono');
    }
}
