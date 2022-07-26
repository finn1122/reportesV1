<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chofere extends Model
{
    use HasFactory;

    protected static function boot(){
        parent::boot();

    }

    //protected $table = "choferes";

    protected $fillable = ['nb_chofer', 'fecha', 'conteo'];



    
}
