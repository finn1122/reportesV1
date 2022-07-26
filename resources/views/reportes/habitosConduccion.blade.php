    <!-- Scripts -->




    <!-- css local tailwind 1.0 -->
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/format.css') }}" rel="stylesheet">


    <!-- Scripts local datepicker 
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    

    <script src="{{ asset('js/loader.js') }}"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">


<style>
    .cuerpo {
  height: 890px;
  width: 1218px;
  background-color: white;
}

.footer {
  width: 1218px;
}
    .border {
   border:2px solid black;
   border-radius:22px;
   margin: 4px;
}

    .logoBachoco{
    position:absolute;

    margin: 7px;


}

    .alto-titulo {
        height: 80px;

}


    .velocidadUno{
    height: 513px;
    background-color: white;
}


    .altoVelocidades{
    height: 335px;
    background-color: white;
    }

    .velocidadDos{
    height: 152px;
    background-color: white;
    }

    .altoVelocidadDosTres{
    height: 400px;
    background-color: white;
    }
    </style>

<div class="cuerpo border bg-white">
    <div class="grid grid-cols-12 mb-0">
        <div class="col-span-3 flex justify-center items-center m-2 ml-3 mb-0" style="height: 50px" ><img src="{{URL::asset('/images/logo-bachoco.png')}}" style="height: 30px;"></div>


        <div class="col-span-6 flex justify-center items-center text-3xl" style="height: 50px">
            <p class="font-sans md:font-serif" >
                Hábitos de conducción {{$cedis}} {{$operacion}}
            </p>
        </div>
        <div class="col-span-3 flex justify-center items-center mr-2 ml-0 text-sm" style="align-content: right">
            <p class="font-sans md:font-serif font-bold"><br>
            Torre de monitoreo T2&nbsp;
            </p>
            <img src="{{URL::asset('/images/torre-monitoreo.png')}}" style="height: 40px; ">
        </div>

    </div>

        <div class="m-2 mt-0" style="border: 1px solid #ff4040">

                    <div id="velocidadGraficoUno" style="border: 1px solid #000" class="m-2 flex justify-center items-center" ></div>
                    

        </div>

        <div class="grid grid-cols-12 gap-1 m-2 altoVelocidadDosTres" style="border: 1px solid #ff4040">

            <div id="velocidadGraficoDos" style="border: 1px solid #000" class="col-span-6 flex justify-center items-center m-2 mb-0" ></div>

            <div id="velocidadGraficoTres" style="border: 1px solid #000" class="col-span-6 flex justify-center items-center m-2 mb-0"></div>
            <div class="col-span-6 mt-0" >
                <p class="font-sans md:font-serif text-center" >
                    EVS = Sobrepasar 60 km/h por mas de 1 min.
                </p>
            </div>
            <div class="col-span-6 mt-0" >
                <p class="font-sans md:font-serif text-center" >
                    EVS = Sobrepasar 100 km/h por mas de 1 min.
                </p>
            </div>

                        
             
        </div>
        

</div>

<div class="footer bg-white">

    <div class="grid grid-cols-12 m-0 text-xs">
        <div class="col-span-9 text-sm">
            <p class="font-sans md:font-serif text-left">
                Gráficos generados con la información recopilada a lo largo de la operación correspondiente.
                Dudas y comentarios con tu analista en turno.
            </p>
        </div>
        
        <div class="col-span-3 text-sm mr-2">
            <p class="text-right font-sans md:font-serif ">Fecha de operación: {{$fechaDMY}}</p>
        </div>

    </div>
</div>




        <script>

//velocidades
$(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaVelocidades(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('velocidades.calcularExcesosVelocidad') }}", // the file to call
                        dataType: 'html',   
                        success: function(velocidades) {

                        if (velocidades) {
                            console.log(velocidades);

                            $('#velocidadGraficoUno').html(velocidades);
                            alert("¡Velocidades listas!");



                        } else {

                            $("#velocidadGraficoUno").empty();
                        }
                        }



                    });
            }

            generarGraficaVelocidades();

        });


        //velocidad local
        $(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaVelocidadesLocales(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('velocidades.velocidadGraficoDos') }}", // the file to call
                        dataType: 'html',   
                        success: function(velocidades) {

                        if (velocidades) {
                            console.log(velocidades);

                            $('#velocidadGraficoDos').html(velocidades);
                            alert("¡Velocidad Foranea lista!");



                        } else {

                            $("#velocidadGraficoDos").empty();
                        }
                        }



                    });
            }

            generarGraficaVelocidadesLocales();

        });


        //velocidad foranea
        $(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaVelocidadesForanea(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                            url: "{{ route('velocidades.velocidadGraficoTres') }}", // the file to call
                            dataType: 'html',   
                            success: function(velocidades) {

                            if (velocidades) {
                                console.log(velocidades);

                                $('#velocidadGraficoTres').html(velocidades);
                                alert("¡Velocidad ruta foránea lista!");



                            } else {

                                $("#velocidadGraficoTres").empty();
                            }
                            }



                        });
            }

            generarGraficaVelocidadesForanea();

        });
</script>