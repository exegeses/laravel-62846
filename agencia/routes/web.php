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
Route::get('/region/create', function ()
{
    return view('regionCreate');
});
Route::post('/region/store', function ()
{
    //capturamos dato enviado por el form
    //$regNombre = $_POST['regNombre'];
    //$regNombre = request()->input('regNombre');
    //$regNombre = request()->regNombre;
    $regNombre = request('regNombre');
    //insertarmos dato en tabla regiones
    try{
        DB::insert(
                'INSERT INTO regiones
                        ( regNombre )
                    VALUES
                        ( :regNombre )',
                    [ $regNombre ]
        );
        //redirección con mensaje ok
        return redirect('/regiones')
                ->with([
                        'mensaje'=>'Región: '.$regNombre.' agregada correctamente',
                        'css'=>'success'
                ]);
    }
    catch ( Throwable $th )
    {
        //redirección con mensaje error
        return redirect('/regiones')
                ->with([
                    'mensaje'=>'No se pudo agregar la región: '.$regNombre,
                    'css'=>'danger'
                ]);
    }
});
Route::get('/region/edit/{id}', function ( $id )
{
    //obtenemos datos de la región a modificar
    $region = DB::select('SELECT idRegion, regNombre
                            FROM regiones
                            WHERE idRegion = :id',
                            [ $id ]
              );
    //retornamos vista del form
    return view('regionEdit', [ 'region'=>$region ]);
});


