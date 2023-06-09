<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //obtenemos listado de marcas
        $marcas = Marca::paginate(6);
        return view('marcas', [ 'marcas'=>$marcas ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marcaCreate');
    }

    private function validarForm( Request $request )
    {
        $request->validate(
                /*
                 * [ 'campo'=>'reglas' ],
                 * [ 'campo.regla'=>'mensaje' ]
                 */
                [ 'mkNombre'=>'required|unique:marcas,mkNombre|min:2|max:30' ],
                [
                    'mkNombre.required'=>'El campo "Nombre de la marca" es obligatorio',
                    'mkNombre.unique'=>'Ya existe una marca con ese nombre',
                    'mkNombre.min'=>'El campo "Nombre de la marca" debe tener al menos 2 caractéres',
                    'mkNombre.max'=>'El campo "Nombre de la marca" debe tener 30 caractéres como máximo'
                ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mkNombre = $request->mkNombre;
        //validación
        $this->validarForm($request);

        return 'si llega hasta acá, es porque pasó la validación';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validación
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
