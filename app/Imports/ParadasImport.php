<?php

namespace App\Imports;

use App\Models\Parada;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ParadasImport implements ToModel, WithHeadingRow

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



        $fechaYMD = Carbon::parse($fecha)->format('Y-m-d');


        $descripcion = $row['descripcion'];
        //$tiempo = $row[1];
        $accion_tratamiento = $row['accion_tratamiento'];

        $clasificacion_incidencia = $row['clasificacion_de_incidencia'];


        $nb_unidad = $row['dominio'];

        //convertir fechaCruda a texto
        $fechaTexto = strval($fechaCruda);

        //convertir columna conteo a string
        $conteoToString = strval($row['conteo']);


        //conteo para comparar al hacer la consulta para obtener el id de la unidad
        $conteoParaComparar= $row['dominio'].$fechaTexto;

        //conteo para guardar en la bd
        $conteo= $row['dominio'].$fechaTexto.$conteoToString;



        //echo $nb_unidad. ' velocidad: '.$velocidad .' ' .$fecha;

        //echo $causa.$fechaYMD.$clasificacion.$nb_unidad;



        $id_unidad = DB::table('unidades')
            ->where('unidades.conteo', '=', $conteoParaComparar)
            ->select('id', 'nb_ruta')
            ->get();

        $id = 0;


        foreach ($id_unidad as $dato){

                $id = $dato->id;
                $ruta = $dato->nb_ruta;


        }


        
        if ($id > 0){



            if ($accion_tratamiento == 'EMBOTELLAMIENTO'){
            
                //guardar campos en tabla unidades

            Parada::updateOrCreate(
                [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'TRAFICO' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
            );

            }


            else if ($accion_tratamiento == 'BAÑO' 
            || $accion_tratamiento == 'GASOLINA' 
            || $accion_tratamiento == 'COMIDA' 
            || $accion_tratamiento == 'DOCUMENTOS PENDIENTES' 
            || $accion_tratamiento == 'LAVADO DE UNIDAD FUERA DE CEDIS'
            || $accion_tratamiento == 'BACOS'
            || $accion_tratamiento == 'BASCULA' 
            || $accion_tratamiento == 'DESCANSO' 
            || $accion_tratamiento == 'DETENCION POR AUTORIDAD' 
            || $accion_tratamiento == 'DEVOLUCION DE PRODUCTO'
            || $accion_tratamiento == 'ENTREGA EN DIFERENTE UBICACION SOLICITADA POR EL CLIENTE' 
            || $accion_tratamiento == 'ENTREGA FUERA DE SISTEMA'
            || $accion_tratamiento == 'FITOSANITARIA'
            || $accion_tratamiento == 'RECOLECCION DE EMBALAJE'
            || $accion_tratamiento == 'RESCATE A RUTA'
            || $accion_tratamiento == 'TALLER'
            || $accion_tratamiento == 'VERIFICACION VEHICULAR'
            || $accion_tratamiento == 'LLANTA BAJA'
            || $accion_tratamiento == 'REVISION INTERNA (CORPORATIVO)'
           
            ){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'PARADA AUTORIZADA' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }


            else if ($accion_tratamiento == 'ERROR EN GEOCERCA')
            {
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'ERROR EN GEOCERCA DEL CLIENTE' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }


            else if ($accion_tratamiento == 'CAMBIO DE BATERIA' 
            || $accion_tratamiento == 'FRENOS' 
            || $accion_tratamiento == 'LLANTAS' 
            || $accion_tratamiento == 'SERVICIO ALINEACION Y BALANCEO' 
            || $accion_tratamiento == 'SOLDADURA'
            || $accion_tratamiento == 'VENTILADOR'
            || $accion_tratamiento == 'MUELLES'
            || $accion_tratamiento == 'SENSOR' 

           
            ){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'FALLA MECANICA' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }


            else if ($accion_tratamiento == 'SIN RESPUESTA POR PARTE DEL JEFE/PROGRAMADOR'){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'PARADA NO AUTORIZADA' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }

            else if ($accion_tratamiento == 'CLIENTE NO GEOLOCALIZADO'){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'SIN LOCALIZACION' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }

            
            else if ($accion_tratamiento == 'SINIESTRO'){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'SINIESTRO (VOLCADURA)' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }

            else if ($accion_tratamiento == 'VEHICULO MAL ASIGNADO'){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'ERROR DE ASIGNACION EN RUTA' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }

            else if ($accion_tratamiento == 'VEHICULO MAL ASIGNADO'){
            
                //guardar campos en tabla unidades

                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'ERROR DE ASIGNACION EN RUTA' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );

            }else{
                Parada::updateOrCreate(
                    [ 'fecha' => $fechaYMD , 'conteo' => $conteo  ],
                    ['descripcion' => $descripcion , 'clasificacion_incidencia' => 'MAL CAPTURADO' , 'accion_tratamiento' => $accion_tratamiento , 'nb_color' => '#90ee90', 'id_unidad' => $id, 'updated_at' => now() ]
                );
            }


            






           

        }


    }
}