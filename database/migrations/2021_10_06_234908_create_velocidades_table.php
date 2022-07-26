<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVelocidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('velocidades', function (Blueprint $table) {
            $table->id();
            $table->string('ubicacion_inicio')->nullable();
            $table->string('ubicacion_fin')->nullable();
            $table->string('latitud_inicio')->nullable();
            $table->string('latitud_fin')->nullable();
            $table->string('long_inicio')->nullable();
            $table->string('long_fin')->nullable();
            $table->string('conteo');
            $table->integer('duracion');
            $table->decimal('velocidad'); 
            $table->date('fecha');           
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
        Schema::dropIfExists('velocidades');
    }
}
