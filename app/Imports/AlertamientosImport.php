<?php

namespace App\Imports;

use App\Models\Evento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AlertamientosImport implements ToModel, WithHeadingRow

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        

        $fechaCruda = $row['fecha'];
        $fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaCruda));
        
        $hora_inicio = $row['hora_inicio'];
        $hora_fin = $row['hora_fin'];

        //formatear columna hora_inicio
        $hora_inicio_con_fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($hora_inicio));
        $hms_inicio = Carbon::parse($hora_inicio_con_fecha)->format('h:i:s');

        //formatear columna hora_fin
        $hora_fin_con_fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($hora_fin));
        $hms_fin = Carbon::parse($hora_fin_con_fecha)->format('h:i:s');

        $totalDuration = $hora_fin_con_fecha->diffInSeconds($hora_inicio_con_fecha);

        $duracion = gmdate('H:i:s', $totalDuration);


        $fechaYMD = Carbon::parse($fecha)->format('Y-m-d');


        $nb_evento = $row['evento'];
        //$tiempo = $row[1];

        $nb_unidad = $row['dominio'];

        //convertir fechaCruda a texto
        $fechaTexto = strval($fechaCruda);

        //convertir columna conteo a string
        $conteoString = strval($row['conteo']);

        $conteo= $row['dominio'].$fechaTexto;

        $street_view = $row['street_view'];


        //echo $nb_unidad. ' evento: '.$nb_evento .' fecha: ' .$fecha;

        echo $duracion. ' ';


        $id_unidad = DB::table('unidades')
            ->where('unidades.fecha', '=', $fechaYMD)
            ->where('unidades.nb_unidad', '=', $nb_unidad)
            ->select('id', 'nb_ruta')
            ->get();

        $id = 0;

        foreach ($id_unidad as $dato){

                $id = $dato->id;
                $ruta = $dato->nb_ruta;


        }


        if ($id > 0){

            

            if ($nb_evento == 'INICIO/FIN JAMMER'){
                //guardar campos en tabla unidades
                /*$eventos = Evento::create([
                'nb_evento' => $nb_evento,
                'nb_color' => '#ffd700',
                'fecha' => $fechaYMD,
                'id_unidad' => $id
            ]);*/

            /*Evento::upsert([
                ['fecha' => $fechaYMD, 'id_unidad' => $id, 'nb_evento' => $nb_evento, 'nb_color' => '#ffd700', 'conteo' => $conteo ],
            ], ['fecha', 'id_unidad', 'conteo'], ['nb_evento', 'nb_color']);*/


            Evento::updateOrCreate(
                ['fecha' => $fechaYMD, 'id_unidad' => $id,   'conteo' => $conteo],
                ['nb_evento' => $nb_evento, 'nb_color' => '#ffd700', 'hora_inicio' => $hms_inicio, 'hora_fin' => $hms_fin, 'street_view' => $street_view, 'duracion' => $duracion]
            );


            //$eventos->save();

            }

            if ($nb_evento == 'BOTON DE EMERGENCIA'){
                //guardar campos en tabla unidades
                /*$eventos = Evento::create([
                'nb_evento' => $nb_evento,
                'nb_color' => '#b22222',
                'fecha' => $fechaYMD,
                'id_unidad' => $id
            ]);

            $eventos->save();*/

            /*Evento::upsert([
                ['fecha' => $fechaYMD, 'id_unidad' => $id, 'nb_evento' => $nb_evento, 'nb_color' => '#b22222', 'conteo' => $conteo  ],
            ], ['fecha', 'id_unidad', 'conteo'], ['nb_evento', 'nb_color']);*/

            Evento::updateOrCreate(
                ['fecha' => $fechaYMD, 'id_unidad' => $id,   'conteo' => $conteo],
                ['nb_evento' => $nb_evento, 'nb_color' => '#b22222', 'hora_inicio' => $hms_inicio, 'hora_fin' => $hms_fin, 'street_view' => $street_view, 'duracion' => $duracion]
            );

            }

            if ($nb_evento == 'PARO DE MOTOR'){
                //guardar campos en tabla unidades
                /*$eventos = Evento::create([
                'nb_evento' => $nb_evento,
                'nb_color' => '#808080',
                'fecha' => $fechaYMD,
                'id_unidad' => $id
            ]);

            $eventos->save();*/

            /*Evento::upsert([
                ['fecha' => $fechaYMD, 'id_unidad' => $id, 'nb_evento' => $nb_evento, 'nb_color' => '#808080', 'conteo' => $conteo  ],
            ], ['fecha', 'id_unidad', 'conteo'], ['nb_evento', 'nb_color']);*/

            Evento::updateOrCreate(
                ['fecha' => $fechaYMD, 'id_unidad' => $id,   'conteo' => $conteo],
                ['nb_evento' => $nb_evento, 'nb_color' => '#808080', 'hora_inicio' => $hms_inicio, 'hora_fin' => $hms_fin, 'street_view' => $street_view, 'duracion' => $duracion ]
            );

            }

            
        }
            
            //echo $id.$ruta.$velocidad;

            //guardar campos en tabla unidades
            /*$paradas = Parada::create([
                'nb_parada' => $clasificacion,
                'nb_causa' => $causa,
                'fecha' => $fechaYMD,
                'id_unidad' => $id
            ]);

            /*return new Velocidade([
                'duracion' => $row[12],
                'velocidad' => $velocidad,
                'fecha' => $fecha,
                'id_unidad' => $id
            ]);
    

        $paradas->save();

        }*/


    }
}
