<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parada extends Model
{
    use HasFactory;

    protected $table = 'paradas';

    protected $fillable = ['descripcion', 'accion_tratamiento', 'clasificacion_incidencia', 'fecha','id_unidad', 'nb_color', 'conteo', 'updated_at'];



}