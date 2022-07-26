<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\ChofereController;
use App\Http\Controllers\VelocidadeController;
use App\Http\Controllers\ParadasController;
use App\Http\Controllers\EventosController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('reportes', ReporteController::class);

//Route::get('/reportes/index', [ReporteController::class, 'index'])->name('reportes.index');

Route::post('/reportes/import', [ReporteController::class, 'import'])->name('reportes.import');

//Route::post('/reportes/reportesPP', [ReporteController::class, 'reportesPP'])->name('reportes.reportesPP');

Route::get('/reportesPP', [ReporteController::class, 'reportesPP'])->name('reportesPP');

Route::get('/reportes/generarReportes/{operacion}', [ReporteController::class, 'generarReportes'])->name('generarReportes');

//Route::get('/reportesPP', [ReporteController::class, 'reportesPP'])->name('reportes-pp');

//Route::post('/become-a-customer', 'BecomeACustomerFormController@postBecomeACustomer')->name('become-a-customer');



Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/reportes/consultarOperacion',  [ReporteController::class, 'consultarOperacion'])->name('reportes.consultarOperacion');

Route::post('/reportes/consultarCedis',  [ReporteController::class, 'consultarCedis'])->name('reportes.consultarCedis');

Route::post('/unidades/disponibilidadFlota',  [UnidadeController::class, 'disponibilidadFlota'])->name('unidades.disponibilidadFlota');

Route::post('/unidades/utilizacionFlota',  [UnidadeController::class, 'utilizacionFlota'])->name('unidades.utilizacionFlota');

Route::post('/unidades/otrasUnidades',  [UnidadeController::class, 'otrasUnidades'])->name('unidades.otrasUnidades');

//Route::post('/unidades/tituloReporte',  [UnidadeController::class, 'tituloReporte'])->name('unidades.tituloReporte');

Route::post('/choferes/informacionFlota',  [ChofereController::class, 'informacionFlota'])->name('choferes.informacionFlota');

Route::post('/velocidades/importarVelocidades', [VelocidadeController::class, 'importarVelocidades'])->name('velocidades.importarVelocidades');

Route::post('/velocidades/calcularExcesosVelocidad', [VelocidadeController::class, 'calcularExcesosVelocidad'])->name('velocidades.calcularExcesosVelocidad');

Route::post('/velocidades/velocidadGraficoDos', [VelocidadeController::class, 'velocidadGraficoDos'])->name('velocidades.velocidadGraficoDos');

Route::post('/velocidades/velocidadGraficoTres', [VelocidadeController::class, 'velocidadGraficoTres'])->name('velocidades.velocidadGraficoTres');

Route::post('/paradas/incidencias', [ParadasController::class, 'incidencias'])->name('paradas.incidencias');

Route::post('/paradas/paradasAutorizadas', [ParadasController::class, 'paradasAutorizadas'])->name('paradas.paradasAutorizadas');

Route::post('/paradas/paradasNoAutorizadas', [ParadasController::class, 'paradasNoAutorizadas'])->name('paradas.paradasNoAutorizadas');

Route::post('/eventos/eventosSeguridad', [EventosController::class, 'eventosGrafico'])->name('eventos.eventosGrafico');

Route::post('/eventos/guardarJustificacion', [EventosController::class, 'guardarJustificacion'])->name('eventos.guardarJustificacion');

Route::post('/reportes/informacionFlota', [ReporteController::class, 'informacionFlota'])->name('reportes.informacionFlota');

Route::post('/reportes/habitosConduccion', [ReporteController::class, 'habitosConduccion'])->name('reportes.habitosConduccion');

Route::post('/reportes/incidenciasRuta', [ReporteController::class, 'incidenciasRuta'])->name('reportes.incidenciasRuta');

Route::post('/reportes/eventosSeguridad', [ReporteController::class, 'eventosSeguridad'])->name('reportes.eventosSeguridad');

Route::post('/eventos/descripcionEventos', [EventosController::class, 'descripcionEventos'])->name('eventos.descripcionEventos');





//Route::post('/reportes/plantillaReporte', [ReporteController::class, 'plantillaReporte'])->name('reportes.plantillaReporte');










