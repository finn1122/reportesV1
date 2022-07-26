
@extends('layouts.app')

@section("content")


<!-- This example requires Tailwind CSS v2.0+ -->
    
    
    <header class="bg-white shadow">

      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">
          Reportes Pollo Vivo
        </h1>
      </div>
    </header>
    <main>
        <br>
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-3" ></div>

            <div class="col-span-3">
                <div class="grid bg-white rounded-lg shadow-xl mx-auto">
                    <form method="POST" enctype="multipart/form-data" action="{{route('reportes.import')}}">
                        @csrf
                        <div class="grid grid-cols-1 mt-5 mx-7 ">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1">Importar asignación de choferes</label>
                            <div class='flex items-center justify-center w-full'>
                                <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                    <div class='flex flex-col items-center justify-center pt-7'>
                                        <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"></path></svg>
                                        <center><span class="block text-gray-400 font-normal" id="nombrePlantillaReportes" name="nombrePlantillaReportes" >Selecciona el archivo CSV</span></center>
                                    </div>
                                    <input type="file" class="form-control h-full w-full opacity-0" id="plantillaReportes" name="plantillaReportes" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                </label>
                            </div>
                        </div>
                        <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                            <button class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancel</button>
                            <button type="file" name="file" class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Subir</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-3">
                <div class="grid bg-white rounded-lg shadow-xl mx-auto">
                    <form method="POST" enctype="multipart/form-data" action="{{route('velocidades.importarVelocidades')}}">
                        @csrf
                        <div class="grid grid-cols-1 mt-5 mx-7 ">
                            <label class="uppercase md:text-sm text-xs text-gray-500 text-light font-semibold mb-1" >Importar archivo de velocidades</label>
                            <div class='flex items-center justify-center w-full'>
                                <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                    <div class='flex flex-col items-center justify-center pt-7'>
                                        <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"></path></svg>
                                        <center><span value="file"class="block text-gray-400 font-normal" id="nombreArchivoVelocidades" name="nombreArchivoVelocidades">Selecciona el archivo</span>
                                    </div>
                                    <input type="file" class="form-control h-full w-full opacity-0" id="velocidades" name="velocidades" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                                </label>
                            </div>
                        </div>
                        <div class='flex items-center justify-center  md:gap-8 gap-4 pt-5 pb-5'>
                            <button class='w-auto bg-gray-500 hover:bg-gray-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Cancel</button>
                            <button type="file" name="file" class='w-auto bg-purple-500 hover:bg-purple-700 rounded-lg shadow-xl font-medium text-white px-4 py-2'>Subir</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-3"></div>
        </div>
        
        <br>


        <form method="POST" action="{{ route('reportes.plantillaReporte') }}" target="_blank">
        @csrf


        <div class="grid grid-cols-5 gap-4 bg-white shadow sm:rounded-md sm:overflow-hidden content-center">
            <div class="col-span-1"></div>


                <div class="col-span-1">
                    

                            <div class="antialiased sans-serif">
                                                    <div class="container mx-auto px-8 py-4 md:py-10">
                                                        <div class="mb-5 w-64">
                                                            <label class="font-bold mb-1 text-gray-700 block">
                                                                <span class="text-gray-700">Fecha</span>
                                                                <div class="antialiased sans-serif">
                                                                    <div class="flex flex-row space-x-4">
                                                                        <div class="relative z-0 w-full mb-5 mx-auto">
                                                                            <input
                                                                                type="text"
                                                                                name="fecha"
                                                                                id="fecha"
                                                                                placeholder=" "
                                                                                onclick="this.setAttribute('type', 'date');"
                                                                                onchange="llenarCedis(this.form)"
                                                                                
                                                                                class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                                                                            />
                                                                            <label for="date" class="absolute duration-300 top-6 -z-1 origin-0 text-gray-700">Date</label>
                                                                            <span class="text-sm text-red-600 hidden" id="error">Date is required</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                </div>
                </div>



                
                <div class="col-span-1">
                                <div class="antialiased sans-serif">
                                    <div class="container mx-auto px-8 py-4 md:py-10">
                                        <div class="mb-5 w-64">
                                            <label class="font-bold mb-1 text-gray-700 block">
                                                <span class="text-gray-700">Cedis</span>
                                                <select
                                                id="cedis" 
                                                name="cedis"
                                                onclick="this.setAttribute('type', 'string');"  
                                                class="form-select block w-full mt-1 pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium">                                                      

                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                </div>
                <div class="col-span-1">

                                    <div class="antialiased sans-serif">
                                        <div class="container mx-auto px-8 py-4 md:py-10">
                                            <div class="mb-5 w-64">
                                            <br>
                                            <input type="submit" name="generarReporte" id="generarReporte" class="p-3 rounded-lg outline-none text-white shadow w-32 justify-center bg-purple-500 hover:bg-purple-700 hover:bg-purple-500">
                                            </div>
                                        </div>
                                    </div>
                
                </div>
            <div class="col-span-1"></div>

        </div>
        </form>


            

        </main>






    <br>

        










            

            

        
        




               
                  <style>
                    .-z-1 {
                      z-index: -1;
                    }
                  
                    .origin-0 {
                      transform-origin: 0%;
                    }
                  
                    input:focus ~ label,
                    input:not(:placeholder-shown) ~ label,
                    textarea:focus ~ label,
                    textarea:not(:placeholder-shown) ~ label,
                    select:focus ~ label,
                    select:not([value='']):valid ~ label {
                      /* @apply transform; scale-75; -translate-y-6; */
                      --tw-translate-x: 0;
                      --tw-translate-y: 0;
                      --tw-rotate: 0;
                      --tw-skew-x: 0;
                      --tw-skew-y: 0;
                      transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate))
                        skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
                      --tw-scale-x: 0.75;
                      --tw-scale-y: 0.75;
                      --tw-translate-y: -1.5rem;
                    }
                  
                    input:focus ~ label,
                    select:focus ~ label {
                      /* @apply text-black; left-0; */
                      --tw-text-opacity: 1;
                      color: rgba(0, 0, 0, var(--tw-text-opacity));
                      left: 0px;
                    }

                    .texto-vertical-2 {
                        writing-mode: vertical-lr;
                        transform: rotate(180deg);
                    }
                  </style>
                  
                  


                  <script>

                    //mostrar nombre del archivo seleccionado
                    document.getElementById('plantillaReportes').onchange = function () {
                        
                        console.log(this.value);
                        document.getElementById('nombrePlantillaReportes').innerHTML = document.getElementById('plantillaReportes').files[0].name;
                        
                        //agregar clase text-purple-400 para colorear el nombre del archivo de color purpura
                        var elemento = document.getElementById("nombrePlantillaReportes");
                        elemento.className += " text-purple-400";

                    }


                    //mostrar nombre del archivo seleccionado
                    document.getElementById('velocidades').onchange = function () {
                        
                        console.log(this.value);
                        document.getElementById('nombreArchivoVelocidades').innerHTML = document.getElementById('velocidades').files[0].name;
                        
                        //agregar clase text-purple-400 para colorear el nombre del archivo de color purpura
                        var elemento = document.getElementById("nombreArchivoVelocidades");
                        elemento.className += " text-purple-400";


                        nombreArchivoVelocidades

                    }



                    //consultar cedis
                    function llenarCedis(theForm) {

                    var fecha = $("#fecha").val();
                    var operacion = 'PV';


                    $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('reportes.consultarCedis') }}", // the file to call
                        dataType: 'json',   
                        success: function(res) {

                        if (res) {
                            console.log(cedis);

                            $("#cedis").empty();
                            $("#cedis").append('<option>Seleccionar</option>');
                            $.each(res, function(key, value) {
                            $("#cedis").append('<option value="' +  value.nb_cedis + '">' + value.nb_cedis +
                                        '</option>');
                            });



                        } else {

                            $("#cedis").empty();
                        }
                        }
                        
                    });
                    }


                    //generarReporte
                    function generarReporte(theForm) {

                        var fecha = $("#date").val();
                        var operacion = $("#operacion").val();
                        var cedis = $("#cedis").val();


                        $.ajax({ // create an AJAX call...
                        data:  {
                            "_token": $("meta[name='csrf-token']").attr("content"),
                            operacion:operacion,
                            fecha:fecha,
                            cedis:cedis

                        },

                        type: "POST", // GET or POST
                        url: "{{ route('unidades.disponibilidadFlota') }}", // the file to call
                        dataType: 'html',   
                        success: function(res) {

                        if (res) {
                            console.log(res);





                        } else {

                            $("#cedis").empty();
                        }
                        }

                        
                        
                    });
                    }


                    
</script>

                                


  
                    

                




                
        
                

                

                







        

            
    </main>

    

    

        
        





@endsection
