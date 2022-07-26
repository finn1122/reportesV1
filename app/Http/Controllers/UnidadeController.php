<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class UnidadeController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    

    public function disponibilidadFlota(Request $request)
    {

        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        $estatus = DB::table('unidades')
            ->select(DB::raw('count(*) as total, nb_estatus'))
            ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->groupBy('nb_estatus')
            ->having('total', '>', 0)
            ->get();

        $disponibles = 0;
        $noDisponibles = 0;
        $ruta = 0;
        $bajaDemanda = 0;
        $sinOperador = 0;
        $descompostura = 0;
        $baja = 0;
        $siniestrado = 0;
        $prestamo = 0;
        $taller = 0;
        $corralon = 0;

        foreach ($estatus as $row){
            //$disponibles = 0;
            if ($row->nb_estatus == 'RUTA'){
                    $ruta = $row->total;
            }
            if ($row->nb_estatus == 'BAJA DEMANDA'){
                $bajaDemanda = $row->total;
            }
            if ($row->nb_estatus == 'SIN OPERADOR'){
            $sinOperador = $row->total;
            }
            if ($row->nb_estatus == 'DESCOMPOSTURA'){
                $descompostura = $row->total;
            }
            if ($row->nb_estatus == 'BAJA'){
                    $baja = $row->total;
            }
            if ($row->nb_estatus == 'SINIESTRADO'){
                $siniestrado = $row->total;
            }
            if ($row->nb_estatus == 'PRESTAMO'){
                $prestamo = $row->total;
            }
            if ($row->nb_estatus == 'TALLER'){
                $taller = $row->total;
            }
            if ($row->nb_estatus == 'CORRALON'){
                $corralon = $row->total;
            }

        }

        $disponibles = $ruta + $bajaDemanda + $sinOperador;
        $noDisponibles = $descompostura + $baja + $siniestrado + $prestamo + $taller + $corralon ;


        //echo $disponibles;
        //echo $noDisponibles;




        
        return view('unidades/disponibilidadFlota', compact('disponibles','noDisponibles'));

        //$respuesta = view('unidades/plantilla')->render();
        //return response()->json(array('success' => true, 'html'=>$respuesta));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function utilizacionFlota(Request $request)
    {

        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        $estatus = DB::table('unidades')
            ->select(DB::raw('count(*) as total, nb_estatus, nb_color'))
            ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->groupBy('nb_color')
            ->groupBy('nb_estatus')
            ->having('total', '>', 0)
            ->get();

        $ruta = 0;
        $bajaDemanda = 0;
        $sinOperador = 0;
        $descompostura = 0;
        $baja = 0;
        $siniestrado = 0;
        $prestamo = 0;
        $taller = 0;
        $corralon = 0;

        foreach ($estatus as $row){
            //$disponibles = 0;
            if ($row->nb_estatus == 'RUTA'){
                    $ruta = $row->total;
            }
            if ($row->nb_estatus == 'BAJA DEMANDA'){
                $bajaDemanda = $row->total;
            }
            if ($row->nb_estatus == 'SIN OPERADOR'){
            $sinOperador = $row->total;
            }
            if ($row->nb_estatus == 'DESCOMPOSTURA'){
                $descompostura = $row->total;
            }
            if ($row->nb_estatus == 'BAJA'){
                    $baja = $row->total;
            }
            if ($row->nb_estatus == 'SINIESTRADO'){
                $siniestrado = $row->total;
            }
            if ($row->nb_estatus == 'PRESTAMO'){
                $prestamo = $row->total;
            }
            if ($row->nb_estatus == 'TALLER'){
                $taller = $row->total;
            }
            if ($row->nb_estatus == 'CORRALON'){
                $corralon = $row->total;
            }

        }
        $fechaDMY = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');



        //echo $estatus;
        /*return view('unidades/utilizacionFlota',compact('ruta'
                                                        , 'bajaDemanda'
                                                        , 'sinOperador'
                                                        , 'descompostura'
                                                        , 'baja'
                                                        , 'siniestrado'
                                                        , 'prestamo'
                                                        , 'taller'
                                                        , 'corralon'
                                                        , 'fechaDMY'
                                                    )); */   
        return view('unidades/utilizacionFlota', compact('estatus', 'fechaDMY'));


    }

    //unidades que no estan en ruta pueden ser en taller, siniestrada, baja demanda, etc.
    public function otrasUnidades(Request $request)
    {

        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");

        /*$otrasUnidades = DB::table('unidades')
            ->select('unidades.nb_unidad', 'unidades.nb_estatus')
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('unidades.nb_estatus', '<>', 'RUTA')
            ->get();*/

            $otrasUnidades = DB::table('unidades')
            ->select('unidades.nb_unidad', 'unidades.nb_estatus')
            ->join('cedis', 'cedis.id', '=', 'unidades.id_cedis')
            ->where('unidades.fecha', '=', $fecha)
            ->where('unidades.nb_operacion', '=', $operacion)
            ->where('cedis.nb_cedis', '=', $cedis)
            ->where('unidades.nb_estatus', '<>', 'RUTA')
            ->get();

        //echo $estatus
        /*return view('unidades/utilizacionFlota',compact('ruta'
                                                        , 'bajaDemanda'
                                                        , 'sinOperador'
                                                        , 'descompostura'
                                                        , 'baja'
                                                        , 'siniestrado'
                                                        , 'prestamo'
                                                        , 'taller'
                                                        , 'corralon'
                                                        , 'fechaDMY'
                                                    )); */   
        return view('unidades/otrasUnidades', compact('otrasUnidades'));


    }



    /*public function tituloReporte(Request $request)
    {

        $operacion = $request->input("operacion");
        $fecha = $request->input("fecha");
        $cedis = $request->input("cedis");




        $fechaDMY = Carbon::parse($fecha)->format('d-m-Y');
        return view('unidades/tituloReporte', compact('cedis', 'fechaDMY', 'operacion'));
    }*/

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
