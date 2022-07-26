<?php

namespace App\Imports;

use App\Models\Cedi;
use App\Models\Chofere;
use App\Models\Unidade;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



use Maatwebsite\Excel\Concerns\ToArray;






class CediImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null

    */




    public function model(array $row)
    {


        //$conteo = $row['conteo'];
        
        $fechaCruda = $row['fecha'];
        $fecha = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaCruda));

        //convertir fechaCruda a texto
        $fechaTexto = strval($fechaCruda);

        $conteo= $row['dominio'].$fechaTexto;
        $cedis = $row['cedis'];
        $chofer = $row['chofer'];

        $date = str_replace('-', '/', $fecha);


        if($conteo != '' ) {




            /*$cedis = Cedi::create([
                'conteo' => $conteo,
                'nb_cedis' => $cedis,
                'fecha' => $fecha,
    
    
    
            ]);
            $cedis->save();*/
            /*Cedi::upsert([
                ['conteo' => $conteo ,  'nb_cedis' => $cedis ,  'fecha' => $fecha ],
            ], ['conteo'], ['nb_cedis']);*/

            Cedi::updateOrCreate(
                ['conteo' => $conteo ,  'fecha' => $fecha],
                [ 'nb_cedis' => $cedis ]
            );


            //guardar campos en tabla choferes
        /*$chofer = Chofere::create([
            'nb_chofer' => $row['chofer'],
            'fecha' => $date,
            'conteo' => $conteo,
        ]);
        
        $chofer->save();*/
            Chofere::updateOrCreate(
                ['conteo' => $conteo, 'fecha' => $date],
                ['nb_chofer' => $row['chofer'] ]
            );


        //consultar id del chofer recien agregado
        $id_chofer = DB::table('choferes')
             ->where('conteo', '=', $conteo)
             ->select('id')
             ->get();

        //codificar consulta para extraer el id del chofer
        $array = json_decode(json_encode($id_chofer), true);

        foreach($array as $dato){
            $id_chofer_int = $dato['id'];
        }  
        
        //consultar id del cedis recien agregado
        $id_cedis = DB::table('cedis')
             ->where('conteo', '=', $conteo)
             ->select('id')
             ->get();

        //condificar consulta para extraer el id del cedis
        $arrayCedis = json_decode(json_encode($id_cedis), true);

        foreach($arrayCedis as $datoCedis){
            $id_cedis_int = $datoCedis['id'];
        }  


        if ($row['estatus'] == 'RUTA'){
            //guardar campos en tabla unidades
            /*$unidade = Unidade::create([
                'nb_unidad' => $row['dominio'],
                'nb_estatus' => $row['estatus'],
                'nb_ruta' => $row['ruta'],
                'nb_operacion' => $row['operacion'],
                'nb_color' => '#87cefa',
                'id_chofer' => $id_chofer_int,
                'id_cedis' => $id_cedis_int,
                'fecha' => $date,
                'conteo' => $conteo,

            ]);

            $unidade->save();*/

            /*Unidade::upsert([
                ['nb_unidad' => $row['dominio']
                , 'nb_estatus' => $row['estatus']
                , 'nb_ruta' => $row['ruta']
                , 'nb_operacion' => $row['operacion']
                , 'nb_color' => '#87cefa'
                , 'id_chofer' => $id_chofer_int
                , 'id_cedis' => $id_cedis_int
                , 'fecha' => $date 
                , 'conteo' => $conteo ],
            ], ['fecha', 'nb_unidad', 'conteo'], ['nb_estatus', 'nb_ruta', 'nb_operacion', 'nb_color', 'id_chofer', 'id_cedis']);*/

            Unidade::updateOrCreate(
                ['nb_unidad' => $row['dominio'],    'id_chofer' => $id_chofer_int, 'id_cedis' => $id_cedis_int, 'fecha' => $date , 'conteo' => $conteo    ],
                ['nb_estatus' => $row['estatus'], 'nb_ruta' => $row['ruta'], 'nb_color' => '#87cefa',  'nb_operacion' => $row['operacion'] ]
            );

        }

        if ($row['estatus'] == 'TALLER'){
            //guardar campos en tabla unidades
            /*$unidade = Unidade::create([
                'nb_unidad' => $row['dominio'],
                'nb_estatus' => $row['estatus'],
                'nb_ruta' => $row['ruta'],
                'nb_operacion' => $row['operacion'],
                'nb_color' => '#ff69b4',
                'id_chofer' => $id_chofer_int,
                'id_cedis' => $id_cedis_int,
                'fecha' => $date,
                'conteo' => $conteo,

            ]);

            $unidade->save();*/

            /*Unidade::upsert([
                ['nb_unidad' => $row['dominio']
                , 'nb_estatus' => $row['estatus']
                , 'nb_ruta' => $row['ruta']
                , 'nb_operacion' => $row['operacion']
                , 'nb_color' => '#A333FF'
                , 'id_chofer' => $id_chofer_int
                , 'id_cedis' => $id_cedis_int
                , 'fecha' => $date 
                , 'conteo' => $conteo ],
            ], ['fecha', 'nb_unidad', 'conteo'], ['nb_estatus', 'nb_ruta', 'nb_operacion', 'nb_color', 'id_chofer', 'id_cedis']);*/
            Unidade::updateOrCreate(
                ['nb_unidad' => $row['dominio'],    'id_chofer' => $id_chofer_int, 'id_cedis' => $id_cedis_int, 'fecha' => $date , 'conteo' => $conteo    ],
                ['nb_estatus' => $row['estatus'], 'nb_ruta' => $row['ruta'], 'nb_color' => '#ffa500',  'nb_operacion' => $row['operacion'] ]
            );


        }

        if ($row['estatus'] == 'SINIESTRADO'){
            //guardar campos en tabla unidades
            /*$unidade = Unidade::create([
                'nb_unidad' => $row['dominio'],
                'nb_estatus' => $row['estatus'],
                'nb_ruta' => $row['ruta'],
                'nb_operacion' => $row['operacion'],
                'nb_color' => '#ff69b4',
                'id_chofer' => $id_chofer_int,
                'id_cedis' => $id_cedis_int,
                'fecha' => $date,
                'conteo' => $conteo,

            ]);

            $unidade->save();*/

            /*Unidade::upsert([
                ['nb_unidad' => $row['dominio']
                , 'nb_estatus' => $row['estatus']
                , 'nb_ruta' => $row['ruta']
                , 'nb_operacion' => $row['operacion']
                , 'nb_color' => '#CF2600'
                , 'id_chofer' => $id_chofer_int
                , 'id_cedis' => $id_cedis_int
                , 'fecha' => $date 
                , 'conteo' => $conteo ],
            ], ['fecha', 'nb_unidad', 'conteo'], ['nb_estatus', 'nb_ruta', 'nb_operacion', 'nb_color', 'id_chofer', 'id_cedis']);*/

            Unidade::updateOrCreate(
                ['nb_unidad' => $row['dominio'],    'id_chofer' => $id_chofer_int, 'id_cedis' => $id_cedis_int, 'fecha' => $date , 'conteo' => $conteo    ],
                ['nb_estatus' => $row['estatus'], 'nb_ruta' => $row['ruta'], 'nb_color' => '#CF2600',  'nb_operacion' => $row['operacion'] ]
            );

        }

        if ($row['estatus'] == 'BAJA DEMANDA'){
            //guardar campos en tabla unidades
            /*$unidade = Unidade::create([
                'nb_unidad' => $row['dominio'],
                'nb_estatus' => $row['estatus'],
                'nb_ruta' => $row['ruta'],
                'nb_operacion' => $row['operacion'],
                'nb_color' => '#ff69b4',
                'id_chofer' => $id_chofer_int,
                'id_cedis' => $id_cedis_int,
                'fecha' => $date,
                'conteo' => $conteo,

            ]);

            $unidade->save();*/
            /*Unidade::upsert([
                ['nb_unidad' => $row['dominio']
                , 'nb_estatus' => $row['estatus']
                , 'nb_ruta' => $row['ruta']
                , 'nb_operacion' => $row['operacion']
                , 'nb_color' => '#00CF79'
                , 'id_chofer' => $id_chofer_int
                , 'id_cedis' => $id_cedis_int
                , 'fecha' => $date 
                , 'conteo' => $conteo ],
            ], ['fecha', 'nb_unidad', 'conteo'], ['nb_estatus', 'nb_ruta', 'nb_operacion', 'nb_color', 'id_chofer', 'id_cedis']);*/

            Unidade::updateOrCreate(
                ['nb_unidad' => $row['dominio'],    'id_chofer' => $id_chofer_int, 'id_cedis' => $id_cedis_int, 'fecha' => $date , 'conteo' => $conteo    ],
                ['nb_estatus' => $row['estatus'], 'nb_ruta' => $row['ruta'], 'nb_color' => '#00CF79',  'nb_operacion' => $row['operacion'] ]
            );


        }

        


        }


       



        

         




        
        



        
     
    }


    

    
}

