<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Autenticacion\AuthController;
use App\Http\Controllers\GestionLibros\GestionLibrosController;
use App\Http\Controllers\GestionPrestamos\GestionPrestamosController;
use App\Http\Controllers\GestionToken\GestionTokenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

/* Definir una ruta para el navegador, como rutas personalizadas */
// Aqui estan definidas todas las rutas en la que se conectan los controladores son las vistas respectivas

Route::controller(AuthController::class)->group(function(){
    //rutas para los controladores del AuthController
    Route::get('/login/loginview', 'loginview')->middleware('guest')->name('login');
    Route::get('/', 'inicio');
    Route::post('/login', 'login');
    Route::get('/register/registerview', 'registerview');
    Route::post('/register', 'register');
    Route::get('/getRol', 'getRol');
    Route::get('/getdetalleu/{detalle}','getdetalleu');
    Route::post('/borraru/{borrar}','borraru');
    Route::post('/buscaru','buscaru');
    Route::post('/{token}','login');
    Route::post('/getestadoau/permiso','getestadoau');
    Route::get('/getadmin','getadmin');

});

Route::middleware(['auth'])->controller(AuthController::class)->group(function(){
    //usamos middelware para que si alguien esta logeado, no vuelva a inicar sesion
    
    Route::get('/', 'inicio');
    Route::post('/login/cerrarsesion', 'logout');
    Route::get('/gestionusuarios', 'gestionusuarios');
    Route::get('/getUsers', 'getUsers');
    Route::post('/vistacrearusuario/crearusuario','crearusuario');
});

Route::middleware(['auth'])->controller(GestionLibrosController::class)->group(function(){
    //usamos middelware para que si alguien esta logeado, no vuelva a inicar sesion
    

    Route::get('/gestionlibros', 'gestionlibros');
    Route::post('/vistacrearlibro/crearlibro', 'crearlibros');
    Route::get('/getlibros','getlibros');
    Route::get('/getlibrodetalle/{detalle}','getdetalle');
    Route::post('/borrarlibro/{borrar}','borrarlibro');
    Route::post('/buscarlibro/buscarli','buscartitulo');

});

Route::middleware(['auth'])->controller(GestionPrestamosController::class)->group(function(){
    //usamos middelware para que si alguien esta logeado, no vuelva a inicar sesion
    

    Route::get('/gestionprestamo', 'gestionprestamo');
    Route::get('/getprestamos', 'getprestamos');
    Route::post('/vistacrearprestamo/crearprestamo','crearprestamos');
    Route::get('/getprestamodetalle/{detalle}','getprestamodetalle');
    Route::post('/borrarprestamo/{borrar}','borrarprestamo');
    
    Route::post('/buscarprestamo/buscarpre','buscarprestamo');
    
   
});

Route::middleware(['auth'])->controller(GestionTokenController::class)->group(function(){
    Route::get('/gestiontoken', 'gestiontoken');
   // Route::get('/token-login/{token}', 'logintoken');
    //Route::post('/generatetoken/generarto', 'generatetoken');
    Route::get('/mostrartoken/mostrarto', 'mostrartokens');
});

Route::controller(GestionTokenController::class)->group(function(){
    Route::get('/gestiontoken', 'gestiontoken');
    Route::get('/token-login/{token}', 'logintoken');
    Route::post('/generatetoken/generarto', 'generatetoken');
    Route::get('/mostrartoken/mostrarto', 'mostrartokens');
});