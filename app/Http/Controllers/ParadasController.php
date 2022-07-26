<?php

namespace App\Http\Controllers;

use App\Models\Parada;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParadasController extends Controller
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


    public function incidencias(Request $request)
    {
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        $agruparIncidencias = DB::table('paradas')
            ->select(DB::raw('count(*) as total, paradas.clasificacion_incidencia, paradas.nb_color'))
            ->join('unidades', 'unidades.id', '=', 'paradas.id_unidad')
            ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('unidades.fecha', '=', $fecha)
            ->where('paradas.fecha', '=', $fecha)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->groupBy('paradas.clasificacion_incidencia')
            ->groupBy('paradas.nb_color')
            ->having('total', '>', 0)
            ->get();

        //echo $agruparIncidencias;

        $incidencias = '';
        foreach($agruparIncidencias as $row){
            $incidencias = $row->clasificacion_incidencia;
        }


        if ($incidencias != null ){ 
            return view('paradas/incidencias', compact('agruparIncidencias'));

        }else{
            return view('paradas/sinIncidencias');
        }
            




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paradasAutorizadas(Request $request)
    {
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");


        $paradasAutorizadas = DB::table('paradas')
            ->select(DB::raw('count(*) as total, paradas.clasificacion_incidencia, paradas.nb_color, paradas.accion_tratamiento'))
            ->join('unidades', 'unidades.id', '=', 'paradas.id_unidad')
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('paradas.fecha', '=', $fecha)
            ->where('paradas.clasificacion_incidencia', '=', 'PARADA AUTORIZADA')
            ->groupBy('paradas.clasificacion_incidencia')
            ->groupBy('paradas.nb_color')
            ->groupBy('paradas.accion_tratamiento')
            ->get();


            $autorizadas = '';
            foreach($paradasAutorizadas as $row){
                $autorizadas = $row->clasificacion_incidencia;
            }
    
    
            if ($autorizadas != null ){ 
                return view('paradas/paradasAutorizadas', compact('paradasAutorizadas'));
    
            }else{
                return view('paradas/sinParadasAutorizadas');
            }
        //echo $paradasAutorizadas;




    }


    public function paradasNoAutorizadas(Request $request)
    {
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");


        $paradasNoAutorizadas = DB::table('paradas')
            ->select(DB::raw('count(*) as total, paradas.clasificacion_incidencia, paradas.nb_color, paradas.accion_tratamiento'))
            ->join('unidades', 'unidades.id', '=', 'paradas.id_unidad')
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('paradas.fecha', '=', $fecha)
            ->where('paradas.clasificacion_incidencia', '=', 'PARADA NO AUTORIZADA')
            ->groupBy('paradas.accion_tratamiento')
            ->groupBy('paradas.clasificacion_incidencia')
            ->groupBy('paradas.nb_color')
            ->get();

        
            $noAutorizadas = '';
            foreach($paradasNoAutorizadas as $row){
                $noAutorizadas = $row->clasificacion_incidencia;
            }
    
    
            if ($noAutorizadas != null ){ 
                return view('paradas/paradasNoAutorizadas', compact('paradasNoAutorizadas'));
    
            }else{
                return view('paradas/sinParadasNoAutorizadas');
            }

        //echo $paradasNoAutorizadas;




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
     * @param  \App\Models\Parada  $parada
     * @return \Illuminate\Http\Response
     */
    public function show(Parada $parada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parada  $parada
     * @return \Illuminate\Http\Response
     */
    public function edit(Parada $parada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parada  $parada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parada $parada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parada  $parada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parada $parada)
    {
        //
    }
}
