<?php

namespace App\Http\Controllers;

use App\Models\Evento;
//use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function eventosGrafico(Request $request)
        {

            $operacion = $request->input("operacion");
            $fecha = $request->input("fecha");
            $cedis = $request->input("cedis");

            $eventos = '';

            //agrupar eventos para generar el grafico
            $agruparEventos = DB::table('eventos')
                ->select(DB::raw('count(*) as total, eventos.nb_evento, eventos.nb_color, eventos.ubicacion'))
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('unidades.fecha', '=', $fecha)
                ->where('eventos.fecha', '=', $fecha)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->groupBy('eventos.nb_evento')
                ->groupBy('eventos.nb_color')
                ->groupBy('eventos.ubicacion')
                ->having('total', '>', 0)
                ->get();

            //echo $agruparEventos;

            foreach ($agruparEventos as $row){
                $eventos = $row->nb_evento;
    
            }

            if ($eventos != null){

                return view('eventos/eventosGrafico', compact('agruparEventos'));

        
            }else{
                return view('eventos/sinEventos');
            }
               
            
            //echo $agruparEventos;




            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardarJustificacion(Request $request)
    {
            $cedis = $request->input("nb_cedis");
            $evento = $request->input("nb_evento");
            $justificacion = $request->input("justificacion");
            $conteo = $request->input("conteo");


            //guardar justificacion

            $eventos = DB::table('eventos')
              ->where('conteo', $conteo)
              ->update(['justificacion' => $justificacion]);

            return back()->with('success','¡justificación guardada!');






    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function descripcionEventos(Request $request)
        {

            $operacion = $request->input("operacion");
            $fecha = $request->input("fecha");
            $cedis = $request->input("cedis");

            $eventos = '';

            //agrupar eventos para generar el grafico
            $agruparEventos = DB::table('eventos')
                ->select(DB::raw('count(*) as total, eventos.nb_evento, eventos.nb_color, eventos.street_view, eventos.hora_inicio,eventos.hora_fin,eventos.duracion, unidades.nb_unidad'))
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('unidades.fecha', '=', $fecha)
                ->where('eventos.fecha', '=', $fecha)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->groupBy('eventos.nb_evento')
                ->groupBy('eventos.nb_color')
                ->groupBy('eventos.street_view')
                ->groupBy('eventos.hora_inicio')
                ->groupBy('eventos.hora_fin')
                ->groupBy('eventos.duracion')
                ->groupBy('unidades.nb_unidad')
                ->having('total', '>', 0)
                ->get();

            //echo $agruparEventos;

            foreach ($agruparEventos as $row){
                $eventos = $row->nb_evento;
    
            }

            if ($eventos != null){

                return view('eventos/descripcionEventos', compact('agruparEventos'));

        
            }else{
                return view('eventos/sinEventos');
            }
               
            
            //echo $agruparEventos;




            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(Evento $evento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evento $evento)
    {
        //
    }
}
