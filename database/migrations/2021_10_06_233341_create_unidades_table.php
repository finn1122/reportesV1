<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nb_unidad');
            $table->string('nb_estatus');
            $table->string('nb_ruta');
            $table->string('nb_operacion');
            $table->string('nb_color');
            $table->date('fecha');
            $table->unsignedBigInteger('id_cedis');
            $table->foreign("id_cedis")->references("id")->on("cedis");
            $table->unsignedBigInteger('id_chofer');
            $table->foreign("id_chofer")->references("id")->on("choferes");
            $table->string('conteo');
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
        Schema::dropIfExists('unidades');
    }
}
