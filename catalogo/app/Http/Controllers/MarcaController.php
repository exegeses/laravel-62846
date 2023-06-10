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
        try {
            //instanciamos
            $Marca = new Marca;
            //asignamos atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos en tabla marcas
            $Marca->save();
            return redirect('/marcas')
                    ->with(
                        [
                            'mensaje'=>'Marca: '.$mkNombre.' agregada correctamente',
                            'css'=>'success'
                        ]
                    );
        }
        catch ( Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo agragar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }

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
        //obtenemos datos de la marca popr su id
        $Marca = Marca::find($id);
        return view('marcaEdit',
            [ 'Marca'=>$Marca ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $idMarca = $request->idMarca;
        $mkNombre = $request->mkNombre;
        //validación
        $this->validarForm($request);
        try {
            //obtenemos marca por su id
            $Marca = Marca::find($idMarca);
            //asignamos atributos
            $Marca->mkNombre = $mkNombre;
            //almacenamos en tabla marcas
            $Marca->save();
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'Marca: '.$mkNombre.' modificada correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch ( Throwable $th ){
            return redirect('/marcas')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar la marca: '.$mkNombre,
                        'css'=>'danger'
                    ]
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
