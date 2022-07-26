<?php

namespace App\Http\Controllers;

use App\Imports\MultipleSheetsImportVelocidades;

use App\Models\Unidade;
use Illuminate\Http\Request;

use Excel;
use App\Imports\VelocidadesImport;

use Illuminate\Support\Facades\DB;


class VelocidadeController extends Controller
{
    
    public function importarVelocidades(Request $request)
    {
//        Excel::import(new VelocidadesImport, request()->file('file'));

            if(request()->file('velocidades')){
                //importar HOJA 0 plantilla-sistema-reportes
                Excel::import(new MultipleSheetsImportVelocidades, request()->file('velocidades'));

                return back()->with('success','¡Archivo subido correctamente!');



            }



    }

    public function calcularExcesosVelocidad(Request $request){
        
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        //consultar excesos locales
        $consultaLocal = DB::table('unidades')
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
            ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
            ->select('unidades.nb_unidad','unidades.nb_ruta','cedis.nb_cedis','choferes.nb_chofer', 'velocidades.velocidad', 'velocidades.duracion')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
            ->where('unidades.nb_estatus', '<>', 'TALLER')
            ->where('unidades.nb_ruta', '=', 'LOCAL')
            ->where('choferes.nb_chofer', '<>', 'NULO')
            ->whereNotNull('choferes.nb_chofer')
            ->get();

        //consultar veces que excedio la velocidad cada chofer
        $consultaRepeticionLocalChofer = DB::table('unidades')
            ->select('choferes.nb_chofer', 'unidades.nb_unidad', DB::raw('count(*) as total'))
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
            ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
            ->where('unidades.nb_estatus', '<>', 'TALLER')
            ->where('unidades.nb_ruta', '=', 'LOCAL')
            ->where('choferes.nb_chofer', '<>', 'NULO')
            ->whereNotNull('choferes.nb_chofer')
            ->groupBy('unidades.nb_unidad')
            ->groupBy('choferes.nb_chofer')
            ->having('total', '>', 0)
            ->get();

 


        $consultaForaneo = DB::table('unidades')
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
            ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
            ->select('unidades.nb_unidad','unidades.nb_ruta','cedis.nb_cedis','choferes.nb_chofer', 'velocidades.velocidad', 'velocidades.duracion')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
            ->where('unidades.nb_estatus', '<>', 'TALLER')
            ->where('unidades.nb_ruta', '=', 'FORANEO')
            ->where('choferes.nb_chofer', '<>', 'NULO')
            ->whereNotNull('choferes.nb_chofer')
            ->get();

        $consultaRepeticionForaneoChofer = DB::table('unidades')
            ->select('choferes.nb_chofer', 'unidades.nb_unidad', DB::raw('count(*) as total'))
            ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
            ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
            ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
            ->where('unidades.nb_estatus', '<>', 'TALLER')
            ->where('unidades.nb_ruta', '=', 'FORANEO')
            ->where('choferes.nb_chofer', '<>', 'NULO')
            ->whereNotNull('choferes.nb_chofer')
            ->groupBy('unidades.nb_unidad')
            ->groupBy('choferes.nb_chofer')
            ->having('total', '>', 0)
            ->get();



        $local = '';
        foreach ($consultaRepeticionLocalChofer as $row){
            $local = $row->nb_unidad;
        }

        $foraneo = '';
        foreach ($consultaRepeticionForaneoChofer as $row){
            $foraneo = $row->nb_unidad;
        }
        

        if ($local == null && $foraneo == null){

            return view('velocidades/sinExcesos');

        }else{
            return view('velocidades/velocidades', compact('consultaRepeticionLocalChofer','consultaRepeticionForaneoChofer'));

        }    


    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function velocidadGraficoDos(Request $request )
    {
               
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        //consultar cada exceso del chofer que excedio la velocidad mas veces
        $consultarNombreChoferConMasExcesos = DB::table('unidades')
        ->select('choferes.nb_chofer', 'unidades.nb_unidad', DB::raw('count(*) as total'))
        ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
        ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
        ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
        ->where('unidades.nb_operacion', '=', $operacion)
        ->where('cedis.nb_cedis', '=', $cedis)
        ->where('unidades.fecha', '=', $fecha)
        ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
        ->where('unidades.nb_estatus', '<>', 'TALLER')
        ->where('unidades.nb_ruta', '=', 'LOCAL')
        ->where('choferes.nb_chofer', '<>', 'NULO')
        ->whereNotNull('choferes.nb_chofer')
        ->groupBy('unidades.nb_unidad')
        ->groupBy('choferes.nb_chofer')
        ->having('total', '>', 0)
        ->orderBy('total', 'DESC')
        ->get()->first();


        if ($consultarNombreChoferConMasExcesos != null){

            foreach ($consultarNombreChoferConMasExcesos as $row){
                $choferMasExcesos = $consultarNombreChoferConMasExcesos->nb_chofer;
                $unidadMasExcesos = $consultarNombreChoferConMasExcesos->nb_unidad;
    
            }
    
            //echo $choferMasExcesos;
    
    
            //consultar veces que se repitio la misma velocidad del chofer con mas excesos
            $consultaRepeticionVelocidadLocalChofer = DB::table('unidades')
                ->select('velocidades.velocidad', DB::raw('count(*) as total'))
                ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
                ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
                ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->where('unidades.fecha', '=', $fecha)
                ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
                ->where('unidades.nb_estatus', '<>', 'TALLER')
                ->where('unidades.nb_ruta', '=', 'LOCAL')
                ->where('choferes.nb_chofer', '=', $choferMasExcesos)
                ->where('unidades.nb_unidad', '=', $unidadMasExcesos)
                ->groupBy('velocidades.velocidad')
                ->having('total', '>', 0)
                ->get();
    
            //echo $consultaRepeticionVelocidadLocalChofer;
            return view('velocidades/graficoDos', compact('consultaRepeticionVelocidadLocalChofer', 'choferMasExcesos', 'unidadMasExcesos'));
    
        }else{
            return view('velocidades/sinExcesosLocales');
        }


        


    }

    public function velocidadGraficoTres(Request $request )
    {
               
        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        //consultar cada exceso del chofer que excedio la velocidad mas veces
        $consultarNombreChoferConMasExcesos = DB::table('unidades')
        ->select('choferes.nb_chofer', 'unidades.nb_unidad', DB::raw('count(*) as total'))
        ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
        ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
        ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
        ->where('unidades.nb_operacion', '=', $operacion)
        ->where('cedis.nb_cedis', '=', $cedis)
        ->where('unidades.fecha', '=', $fecha)
        ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
        ->where('unidades.nb_estatus', '<>', 'TALLER')
        ->where('unidades.nb_ruta', '=', 'FORANEO')
        ->where('choferes.nb_chofer', '<>', 'NULO')
        ->whereNotNull('choferes.nb_chofer')
        ->groupBy('unidades.nb_unidad')
        ->groupBy('choferes.nb_chofer')
        ->having('total', '>', 0)
        ->orderBy('total', 'DESC')
        ->get()->first();




        if ($consultarNombreChoferConMasExcesos != null){

            foreach ($consultarNombreChoferConMasExcesos as $row){
                $choferMasExcesosForaneo = $consultarNombreChoferConMasExcesos->nb_chofer;
                $unidadMasExcesosForaneo = $consultarNombreChoferConMasExcesos->nb_unidad;
    
            }
    
            //echo $choferMasExcesos;
    
    
            //consultar veces que se repitio la misma velocidad del chofer con mas excesos
            $consultaRepeticionVelocidadForaneoChofer = DB::table('unidades')
                ->select('velocidades.velocidad', DB::raw('count(*) as total'))
                ->join('cedis', 'unidades.id_cedis', '=', 'cedis.id')
                ->join('choferes', 'unidades.id_chofer', '=', 'choferes.id')
                ->join('velocidades', 'velocidades.id_unidad', '=', 'unidades.id')
                ->where('unidades.nb_operacion', '=', $operacion)
                ->where('cedis.nb_cedis', '=', $cedis)
                ->where('unidades.fecha', '=', $fecha)
                ->where('unidades.nb_estatus', '<>', 'BAJA DEMANDA')
                ->where('unidades.nb_estatus', '<>', 'TALLER')
                ->where('unidades.nb_ruta', '=', 'FORANEO')
                ->where('choferes.nb_chofer', '=', $choferMasExcesosForaneo)
                ->where('unidades.nb_unidad', '=', $unidadMasExcesosForaneo)
                ->groupBy('velocidades.velocidad')
                ->having('total', '>', 0)
                ->get();
    
                return view('velocidades/graficoTres', compact('consultaRepeticionVelocidadForaneoChofer', 'choferMasExcesosForaneo', 'unidadMasExcesosForaneo'));


        }else{
            return view('velocidades/sinExcesosForaneos');
        }


        
        /*if($choferMasExcesosForaneo != null){
            return view('velocidades/graficoTres', compact('consultaRepeticionVelocidadForaneoChofer', 'choferMasExcesosForaneo', 'unidadMasExcesosForaneo'));

        }else{
            return view('velocidades/sinExcesosForaneos');
        }*/




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
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidade $unidade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        //
    }
}
