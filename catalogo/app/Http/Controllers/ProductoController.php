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

    private function validarForm( Request $request ) : void
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

    private function subirImagen( Request $request ) : string
    {
        //si no envían imagen store()
        $prdImagen = 'noDisponible.png';

        //si no envían imagen update()
        if( $request->has('imgActual') ){
            //$prdImagen = $request->imgActual;
            return $request->imgActual;
        }

        //si envían imagen
        if( $request->file('prdImagen') ){
            $archivo =  $request->file('prdImagen');
            //renombramos archivo
            $extension = $archivo->getClientOriginalExtension();
            $prdImagen = time().'.'.$extension;
            //movemos el archivo
            $archivo->move( public_path('imagenes/productos/'), $prdImagen );
        }
        return $prdImagen;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prdNombre = $request->prdNombre;
        //validación
        $this->validarForm($request);
        //subir imagen
        $prdImagen = $this->subirImagen($request);
        try {
            $Producto = new Producto;
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' agregado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch( \Throwable $th ){
            return redirect('/productos')
                    ->with(
                        [
                            'mensaje'=>'No se pudo agregar el producto: '.$prdNombre,
                            'css'=>'danger'
                        ]
                    );
        }
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
    public function edit( $id )
    {
        //obtenemos datos de productos por su id
        $Producto = Producto::find($id);
        //obtenemos listado de marcas y de categorías
        $marcas = Marca::all();
        $categorias = Categoria::all();
        return view('productoEdit',
            [
                'Producto'  => $Producto,
                'marcas'    => $marcas,
                'categorias'=> $categorias
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $prdNombre = $request->prdNombre;
        //validación
        $this->validarForm($request);
        //subir imagen *
        $prdImagen = $this->subirImagen($request);
        try {
            $Producto = Producto::find($request->idProducto);
            $Producto->prdNombre = $prdNombre;
            $Producto->prdPrecio = $request->prdPrecio;
            $Producto->idMarca = $request->idMarca;
            $Producto->idCategoria = $request->idCategoria;
            $Producto->prdDescripcion = $request->prdDescripcion;
            $Producto->prdImagen = $prdImagen;
            $Producto->save();
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' modificado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch( \Throwable $th ){
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'No se pudo modificar el producto: '.$prdNombre,
                        'css'=>'danger'
                    ]
                );
        }

    }

    public function confirmarBaja( $id )
    {
        //obtenemos datos de producto
        $Producto = Producto::with(['getMarca', 'getCategoria'])->find($id);
        return view('productoDelete', [ 'Producto'=>$Producto ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $prdNombre = $request->prdNmobre;
        try {
            Producto::destroy($request->idProducto);
            //si queremos eliminar el archivo SI NO ES 'noDisponible.png'
            //unlink(public_path('imagenes/productos/').$request->prdImagen);
            return redirect('/productos')
                ->with(
                    [
                        'mensaje'=>'Producto: '.$prdNombre.' elimnado correctamente',
                        'css'=>'success'
                    ]
                );
        }
        catch( \Throwable $th ) {
            return redirect('/productos')
                ->with(
                    [
                        'mensaje' => 'No se pudo elimnar el producto: ' . $prdNombre,
                        'css' => 'danger'
                    ]
                );
        }
    }
}
