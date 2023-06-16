<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('inicio');
});

//Route::get('/petición', [ Controlador::class, 'metodo' ] );
#################################
##### CRUD de marcas
use App\Http\Controllers\MarcaController;
Route::get('/marcas', [ MarcaController::class, 'index' ] );
Route::get('/marca/create', [ MarcaController::class, 'create' ]);
Route::post('/marca/store', [ MarcaController::class, 'store' ]);
Route::get('/marca/edit/{id}', [ MarcaController::class, 'edit' ]);
Route::put('/marca/update', [ MarcaController::class, 'update' ]);
Route::get('/marca/delete/{id}', [ MarcaController::class, 'confirmarBaja' ]);
Route::delete('/marca/destroy', [ MarcaController::class, 'destroy' ]);

#################################
##### CRUD de categorías
use App\Http\Controllers\CategoriaController;
Route::get('/categorias', [ CategoriaController::class, 'index' ]);
