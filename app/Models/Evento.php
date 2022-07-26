<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = ['nb_evento', 'justificacion', 'hora', 'fecha', 'id_unidad', 'nb_color', 'conteo', 'hora_inicio', 'hora_fin', 'street_view', 'duracion'];


}