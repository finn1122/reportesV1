<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    use HasFactory;

    protected static function boot(){
        parent::boot();

    }

    //protected $table = "choferes";

    protected $fillable = ['nb_unidad', 'nb_estatus', 'id_chofer','id_cedis', 'conteo', 'fecha', 'nb_ruta', 'nb_operacion', 'nb_color'];



    
}
