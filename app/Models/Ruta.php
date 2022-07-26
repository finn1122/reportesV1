<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    
    protected static function boot(){
        parent::boot();


        /*self::creating(function ($table){
            if(! app()->runningInConsole()){
                $table->user_id = auth()->id();
            }
        });*/
    }

    protected $fillable = ['nb_ruta', 'fecha', 'conteo'];

    


    /*protected $table = "cedis";



    public static function getCedi(){
        
    $records = DB::table('cedis')->select('nb_cedis')->get();
        return $records;

        echo 'hola';
    }*/






}
