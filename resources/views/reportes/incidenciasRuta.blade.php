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

    .texto-vertical-2 {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
}


    .velocidadUno{
    height: 313px;
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

</style>

<div class="cuerpo border bg-white">
    <div class="grid grid-cols-12 mb-0">
        <div class="col-span-3 flex justify-center items-center m-2 mb-0" style="height: 50px" ><img src="{{URL::asset('/images/logo-bachoco.png')}}" style="height: 30px;"></div>


        <div class="col-span-6 flex justify-center items-center text-3xl" style="height: 50px">
            <p class="font-sans md:font-serif" >
                Incidencias de ruta {{$cedis}} {{$operacion}} 
            </p>
        </div>
        <div class="col-span-3 flex justify-center items-center mr-2 ml-0 text-sm" style="align-content: right">
            <p class="font-sans md:font-serif font-bold"><br>
            Torre de monitoreo T2&nbsp;
            </p>
            <img src="{{URL::asset('/images/torre-monitoreo.png')}}" style="height: 40px; ">
        </div>


    </div>
    <div class="grid grid-cols-12 gap-1 m-2 mt-0" style="border: 1px solid #ff4040">
        <div class="col-span-12 m-2 flex justify-center items-center" id="incidencias"  style="border: 1px solid #000"></div>
    </div>
    <div class="grid grid-cols-12 gap-1 m-2" style="border: 1px solid #ff4040">
        <div class="col-span-6 m-2" id="paradasAutorizadas" style="border: 1px solid #000"></div>
        <div class="col-span-6 flex justify-center items-center m-2" id="paradasNoAutorizadas" style="border: 1px solid #000"></div>
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

            //incidencias
        $(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaIncidencias(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('paradas.incidencias') }}", // the file to call
                        dataType: 'html',   
                        success: function(incidencias) {

                        if (incidencias) {
                            console.log(incidencias);

                            $('#incidencias').html(incidencias);
                            alert("¡Incidencias listas!");



                        } else {

                            $("#incidencias").empty();
                        }
                        }



                    });
            }

            generarGraficaIncidencias();

        });


                    //paradas autorizadas
                    $(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaParadasAutorizadas(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('paradas.paradasAutorizadas') }}", // the file to call
                        dataType: 'html',   
                        success: function(paradasAutorizadas) {

                        if (paradasAutorizadas) {
                            console.log(paradasAutorizadas);

                            $('#paradasAutorizadas').html(paradasAutorizadas);
                            alert("¡Paradas autorizadas listas!");



                        } else {

                            $("#paradasAutorizadas").empty();
                        }
                        }



                    });
            }

            generarGraficaParadasAutorizadas();

        });



        //paradas no autorizadas
        $(document).ready(function(){
                    //hacemos focus al campo de búsqueda

                    var fecha = '{{$fecha}}';
                    var operacion = '{{$operacion}}';
                    var cedis = '{{$cedis}}';

                    function generarGraficaNoParadasAutorizadas(){          
                        //hace la búsqueda
                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('paradas.paradasNoAutorizadas') }}", // the file to call
                        dataType: 'html',   
                        success: function(paradasNoAutorizadas) {

                        if (paradasNoAutorizadas) {
                            console.log(paradasNoAutorizadas);

                            $('#paradasNoAutorizadas').html(paradasNoAutorizadas);
                            alert("¡Paradas no autorizadas listas!");



                        } else {

                            $("#paradasNoAutorizadas").empty();
                        }
                        }



                    });
            }

            generarGraficaNoParadasAutorizadas();

        });


        </script>