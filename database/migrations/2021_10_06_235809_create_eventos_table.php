<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nb_evento');
            $table->string('justificacion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->longText('street_view')->nullable();
            $table->string('nb_color');
            $table->time('hora_inicio')->nullable();;
            $table->time('hora_fin')->nullable();;
            $table->time('duracion')->nullable();
            $table->date('fecha');
            $table->string('conteo');
            $table->unsignedBigInteger('id_unidad');
            $table->foreign("id_unidad")->references("id")->on("unidades");
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
        Schema::dropIfExists('eventos');
    }
}
