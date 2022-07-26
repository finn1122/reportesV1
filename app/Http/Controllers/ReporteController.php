<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use Illuminate\Http\Request;

//excel
use App\Exports\CediExport;
use Excel;
use App\Imports\CediImport;
use App\Imports\MultipleSheetsImport;
use App\Imports\MultipleSheetsImportParadas;
use App\Imports\MultipleSheetsImportAlertamientos;

use App\Models\Evento;



use Carbon\Carbon;


use Illuminate\Support\Facades\DB;


class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*public function __construct()
    {
        $this->middleware("auth");
    }*/
    

    public function index()
    {
       // return view('reportes/index');
    }
    
    public function generarReportes($operacion)
    {


        /*$agruparEventos = DB::table('eventos')

                ->select('eventos.conteo', DB::raw('count(*) as total, cedis.nb_cedis, eventos.nb_evento'))
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('eventos.justificacion', '=', '')
                ->orWhereNull('eventos.justificacion')
                ->groupBy('cedis.nb_cedis')
                ->groupBy('eventos.nb_evento')
                ->groupBy('eventos.conteo')
                ->having('total', '>', 0)
                ->get();*/


                /*$agruparEventos = Evento::select(['eventos.*'])
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('eventos.justificacion', '=', '')
                ->orWhereNull('eventos.justificacion')
                ->groupBy('nb_evento')
                ->groupBy('cedis.nb_cedis')

                ->count();*/

                $agruparEventos = DB::table('eventos')

                       ->select('cedis.nb_cedis', 'nb_evento', 'eventos.conteo', 'eventos.fecha', 'unidades.nb_operacion')
                       ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                       ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                       ->where('eventos.justificacion', '=', '')
                       ->orWhereNull('eventos.justificacion')
                       ->where('unidades.nb_operacion', '=', $operacion)
                       ->get();

        //echo $agruparEventos;

        return view('reportes/reportes', compact('agruparEventos', 'operacion'));
    }

    public function reportesPP()
    {
    }

    public function import(Request $request){

        
        if(request()->file('plantillaReportes')){
            //importar HOJA 0 plantilla-sistema-reportes
            Excel::import(new MultipleSheetsImport, request()->file('plantillaReportes'));

            //return back()->with('success','¡Archivo subido correctamente!');



        }
        

        //importar HOJA 2 plantilla-sistema-reportes
        Excel::import(new MultipleSheetsImportParadas, request()->file('plantillaReportes'));

        //importar HOJA 2 plantilla-sistema-reportes
        Excel::import(new MultipleSheetsImportAlertamientos, request()->file('plantillaReportes'));

        //Excel::import(new MultipleSheetsImport, $request->file);
  


    }



    public function consultarOperacion(Request $request)
    {

        
        if ($request->isMethod('post')){
            $fecha = $request->input("data");


            $operacion = DB::table('unidades')
            ->select('nb_operacion')
            ->where('fecha', '=', $fecha)
            ->distinct()
            ->get();

            return response()->json($operacion);
        }

    }


    public function consultarCedis(Request $request)
    {
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");

        
        $cedis = DB::table('unidades')
            ->join('cedis', 'cedis.id', '=', 'unidades.id_Cedis')
            ->select('cedis.nb_cedis', 'cedis.fecha')
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_operacion', '=', $operacion)
            ->distinct()
            ->get();


            
        return response()->json($cedis);

        //echo $cedis;

    }

    public function generarReporte()
    {
        /*$operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");*/


        //return response()->json($cedis);
        //return view('reportes/plantilla', compact('operacion', 'fecha', 'cedis'))->render();

        /*$grafico = view('reportes/plantilla', compact('operacion', 'fecha', 'cedis'))->render();
        return response()->json(array('success' => true, 'html'=>$grafico));*/

        return view('reportes/plantilla');

            
        //return response()->json($cedis);

        //echo 'operación: '.$operacion. ' fecha: '.$fecha.' cedis: '.$cedis;

    }
    /*public function search(Request $request)
    {
        $results = Post::where('title', 'LIKE', "%{$request->search}%")->get();
        return view('posts.results', compact('results'))->with(['search' => $request->search])->render();
    }*/



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function informacionFlota(Request $request)
    {

        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");
        $operacion = $request->input("operacion");


        $fechaDMY = Carbon::parse($fecha)->format('d-m-Y');


        

            $agruparEventos = DB::table('eventos')
                ->select(DB::raw('count(*) as total, eventos.nb_evento, justificacion'))
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('unidades.fecha', '=', $fecha)
                ->where('eventos.fecha', '=', $fecha)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->groupBy('eventos.nb_evento')
                ->groupBy('eventos.justificacion')
                ->having('total', '>', 0)
                ->get();

        $justificacion = '';
        
        foreach ($agruparEventos as $row){
            $justificacion = $row->justificacion;
        }
        
        if ($justificacion != null){
        
            return view('reportes/informacionFlota', compact('operacion', 'fechaDMY', 'cedis', 'fecha', 'agruparEventos'));

        }else{
            return view('reportes/informacionFlota', compact('operacion', 'fechaDMY', 'cedis', 'fecha'));
        }

        
        //echo $agruparEventos;


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function habitosConduccion(Request $request)
    {
        
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");
        $operacion = $request->input("operacion");

        $fechaDMY = Carbon::parse($fecha)->format('d-m-Y');

        return view('reportes/habitosConduccion', compact('operacion', 'fechaDMY', 'cedis', 'fecha'));



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function incidenciasRuta(Request $request)
    {
        
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");
        $operacion = $request->input("operacion");

        $fechaDMY = Carbon::parse($fecha)->format('d-m-Y');

        return view('reportes/incidenciasRuta', compact('operacion', 'fechaDMY', 'cedis', 'fecha'));



    }

    public function eventosSeguridad(Request $request)
        {

            $operacion = $request->input("operacion");
            $fecha = $request->input("fecha");
            $cedis = $request->input("cedis");

            $fechaDMY = Carbon::parse($fecha)->format('d-m-Y');


            //agrupar los eventos para la justificacion
            $agruparEventos = DB::table('eventos')
                ->select(DB::raw('count(*) as total, eventos.nb_evento, justificacion'))
                ->join('unidades', 'unidades.id', '=', 'eventos.id_unidad')
                ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('unidades.fecha', '=', $fecha)
                ->where('eventos.fecha', '=', $fecha)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->groupBy('eventos.nb_evento')
                ->groupBy('eventos.justificacion')
                ->having('total', '>', 0)
                ->get();

        $justificacion = '';
        foreach ($agruparEventos as $row){
            $justificacion = $row->justificacion;
        }
        
        if ($justificacion != null){
        
            return view('reportes/eventosSeguridad', compact('operacion', 'fechaDMY', 'cedis', 'fecha', 'agruparEventos'));

        }else{
            return view('reportes/eventosSeguridad', compact('operacion', 'fechaDMY', 'cedis', 'fecha'));
        }

        
        //echo $agruparEventos;
        //return view('reportes/eventosSeguridad', compact('operacion', 'fechaDMY', 'cedis', 'fecha'));

            




            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Reporte $reporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporte $reporte)
    {
        //
    }
}
