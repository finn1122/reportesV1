<?php

namespace App\Http\Controllers;

use App\Models\Chofere;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class ChofereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function informacionFlota(Request $request)
    {
        //return view('unidades/plantilla', compact('disponibles','noDisponibles'));
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        $choferes = DB::table('unidades')
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
            ->select('unidades.nb_unidad','unidades.nb_ruta','cedis.nb_cedis','choferes.nb_chofer', 'choferes.fecha', 'unidades.nb_operacion')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('choferes.nb_chofer', '<>', 'NULO')
            ->where('choferes.nb_chofer', '<>', 'NO APLICA')
            ->whereNotNull('choferes.nb_chofer')
            ->get();

        //echo $choferes;

        $sinChoferes = '';


        //contar el numero de choferes para ajustar los tamaño del resto de reportes
        $contador =  0; 

        foreach($choferes as $row){

            $sinChoferes = $row->nb_chofer;
            $contador= $contador + 1; 


        }

        if($sinChoferes != null){
            return view('choferes/informacionFlota', compact('choferes', 'contador'));

        }else{
            return view('choferes/sinInformacionFlota');
        }

        //echo $operacion.$fecha.$cedis;



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chofere  $chofere
     * @return \Illuminate\Http\Response
     */
    public function show(Chofere $chofere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chofere  $chofere
     * @return \Illuminate\Http\Response
     */
    public function edit(Chofere $chofere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chofere  $chofere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chofere $chofere)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chofere  $chofere
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chofere $chofere)
    {
        //
    }
}
