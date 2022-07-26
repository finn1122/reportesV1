<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Velocidade extends Model
{
    use HasFactory;

    protected $table = 'velocidades';

    protected $fillable = ['fecha', 'duracion','conteo', 'velocidad','id_unidad'];


}
