<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //obtenemos listado de productos
        //$productos = Producto::paginate(3);
        /* $productos = Producto::join('marcas', 'productos.idMarca', '=', 'marcas.idMarca')
                             ->join('categorias', 'productos.idCategoria', '=', 'categorias.idCategoria')
                             ->paginate(3); */
        $productos = Producto::with(['getMarca','getCategoria'])->paginate(4);

        return view('productos', [ 'productos'=>$productos ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //obtenemos listados de marcas y de categorias
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoCreate',
                [
                    'marcas'=>$marcas,
                    'categorias'=>$categorias
                ]
        );
    }

    private function validarForm( Request $request )
    {
        $request->validate(
                [
                    'prdNombre'=>'required|min:2|max:75',
                    'prdPrecio'=>'required|numeric|min:0',
                    'idMarca'=>'required',
                    'idCategoria'=>'required',
                    'prdDescripcion'=>'required|min:1|max:140',
                    'prdImagen'=>'mimes:jpg,jpeg,png,gif,svg,webp|max:5120'
                ],
                [
                    'prdNombre.required' => 'El campo "Nombre del producto" es obligatorio.',
                    'prdNombre.min'=>'El campo "Nombre del producto" debe tener como mínimo 2 caractéres.',
                    'prdNombre.max'=>'El campo "Nombre" debe tener 75 caractéres como máximo.',
                    'prdPrecio.required'=>'Complete el campo Precio.',
                    'prdPrecio.numeric'=>'Complete el campo Precio con un número.',
                    'prdPrecio.min'=>'Complete el campo Precio con un número mayor a 0.',
                    'idMarca.required'=>'Seleccione una marca.',
                    'idCategoria.required'=>'Seleccione una categoría.',
                    'prdDescripcion.required'=>'Complete el campo Descripción.',
                    'prdDescripcion.min'=>'Complete el campo Descripción con al menos 1 caractéres',
                    'prdDescripcion.max'=>'Complete el campo Descripción con 140 caractéres como máxino.',
                    'prdImagen.mimes'=>'Debe ser una imagen.',
                    'prdImagen.max'=>'Debe ser una imagen de 5MB como máximo.'
                ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prdNombre = $request->prdNombre;
        //validación
        $this->validarForm($request);

        //si llega hasta acá, es porque pasó la validación
        return 'pasó la validación';
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
