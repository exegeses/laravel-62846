<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::metodo('peticion', acción );
Route::view('/hola', 'saludo');

Route::view('/inicio', 'inicio');
Route::get('/datos', function ()
{
    /* pasaje de datos a una vista */
    $marcas = [
            'Sansumg', 'iPhone', 'Xiaomi',
            'LG', 'Blackberry', 'Nokia'
    ];
    return view('datos',
                    [
                        'nombre'=>'marcos',
                        'numero'=>22,
                        'marcas'=> $marcas
                    ]
    );
});

/*##################
 * CRUD de regiones
 * */
Route::get('/regiones', function ()
{
    //obtenemos listado de regiones
    $regiones = DB::select('SELECT idRegion, regNombre
                               FROM regiones');
    return view('regiones', [ 'regiones'=>$regiones ]);
});
