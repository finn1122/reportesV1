<?php

namespace App\Imports;

use App\Models\Velocidade;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStartRow;





class VelocidadesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        $fechaCruda = $row['fecha_inicio'];
        $fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaCruda));


        //$consulta->fecha->format('Y-m-d');

        $fechaYMD = Carbon::parse($fecha)->format('Y-m-d');


        $nb_unidad = $row['placa'];
        //$tiempo = $row[1];
        $velocidad = $row['maxima_velocidad_alcanzada'];

        $tiempo = $row['tiempo'];

        //convertir fechaCruda a texto
        $fechaTexto = strval($fechaCruda);

        //conteo para guardar en la bd
        $conteo= $nb_unidad.$fechaTexto;


        //echo $nb_unidad. ' velocidad: '.$velocidad .' ' .$fecha;

        echo $fechaYMD;

        $id_unidad = DB::table('unidades')
            ->where('unidades.fecha', '=', $fechaYMD)
            ->where('unidades.nb_unidad', '=', $nb_unidad)
            ->select('id', 'nb_ruta')
            ->get();

        $id = 0;
        echo $id_unidad;


        foreach ($id_unidad as $dato){

                $id = $dato->id;
                $ruta = $dato->nb_ruta;


        }




        //guardar excesos locales

        if ($id > 0 && $ruta == 'LOCAL' && $velocidad >= 61){
            
            //echo $id.$ruta.$velocidad;

            //guardar campos en tabla unidades
            /*$velocidades = Velocidade::create([
                'duracion' => $tiempo,
                'conteo' => $conteo,
                'velocidad' => $velocidad,
                'fecha' => $fechaYMD,
                'id_unidad' => $id
            ]);*/


            Velocidade::updateOrCreate(
                ['conteo' => $conteo ,  'fecha' => $fechaYMD, 'id_unidad' => $id],
                [ 'duracion' => $tiempo, 'velocidad' => $velocidad,  ]
            );

            /*return new Velocidade([
                'duracion' => $row[12],
                'velocidad' => $velocidad,
                'fecha' => $fecha,
                'id_unidad' => $id
            ]);*/
    

        //$velocidades->save();

        }

        //guardar excesos foraneos
        if ($id > 0 && $ruta == 'FORANEO' && $velocidad >= 101){
            
            //echo $id.$ruta.$velocidad;

            //guardar campos en tabla unidades
            /*$velocidades = Velocidade::create([
                'duracion' => $tiempo,
                'conteo' => $conteo,
                'velocidad' => $velocidad,
                'fecha' => $fechaYMD,
                'id_unidad' => $id

            ]);

        $velocidades->save();*/

            velocidade::updateOrCreate(
                ['conteo' => $conteo ,  'fecha' => $fechaYMD, 'id_unidad' => $id],
                [ 'duracion' => $tiempo, 'velocidad' => $velocidad,  ]
            );

        }
        
        



        
    }

    public function headingRow(): int
    {
        return 2;
    }

    


}


