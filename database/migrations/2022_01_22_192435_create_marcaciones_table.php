<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->bigInteger('asignacion_id')->unsigned();
            $table->foreign('asignacion_id')->references('id')->on('asignaciones');
            $table->time('entrada');
            $table->time("salida");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcaciones');
    }
}
