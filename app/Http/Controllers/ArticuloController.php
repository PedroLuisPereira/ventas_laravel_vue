<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Articulo;
use Illuminate\Support\Facades\DB;


class ArticuloController extends Controller
{
    /**
     * consultar articulos
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        $articulos = DB::table('articulos')
            ->join('categorias', 'articulos.categoria_id', '=', 'categorias.id')
            ->select('articulos.*', 'categorias.nombre as nombre_categoria')
            ->where('articulos.id', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.codigo', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.nombre', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.precio_venta', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.stock', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.descripcion', 'like', '%' . $request->buscar . '%')
            ->orWhere('articulos.condicion', 'like', '%' . $request->buscar . '%')
            ->orWhere('categorias.nombre', 'like', '%' . $request->buscar . '%')
            ->paginate(1);

        //retornar los resultados con paginacion 
        return [
            'paginate' => [
                'total' => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page' => $articulos->perPage(),
                'last_page' => $articulos->lastPage(),
                'from' => $articulos->firstItem(),
                'to' => $articulos->lastPage(),
            ],
            'articulos' => $articulos

        ];
        
    }

    /**
     * consultar articulos
     *
     * @return \Illuminate\Http\Response
     */
    public function consultarArticulo(Request $request)
    {

        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar consulta
        $articulo = Articulo::where('codigo', '=', $request->buscar)
            ->get();

        //retornar los resultados
        return $articulo; 
    }


    /**
     * Crear nuevo articulo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //Validaciones
        $validatedData = $request->validate([
            'codigo' => 'required|unique:articulos|max:50',
        ]);

        //crear objeto
        $articulo = new Articulo();
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = 1;
        $articulo->categoria_id = $request->categoria_id;
        $articulo->save();

        //respuesta     
        return response()->json(["mensaje" => "Articulo Registrado"], 200);
    }


    /**
     * Actualizar un articulo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //Validaciones
        $validatedData = $request->validate([
            'codigo' => 'required|unique:articulos|max:50',
        ]);

        //buscar objeto y realizar actualizacion 
        $articulo = Articulo::findOrFail($request->id);
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = 1;
        $articulo->categoria_id = $request->categoria_id;
        $articulo->save();

        //retornar respuesta
        return response()->json(["mensaje" => "Articulo Actualizado"], 200);
    }

    /**
     * Activar o desactivar articulo
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //buscar articulo 
        $articulo = Articulo::findOrFail($request->id);

        //realizar operacion 
        if ($articulo->condicion == 1) {

            $articulo->condicion = 0;
        } else {

            $articulo->condicion = 1;
        }

        $articulo->save();
        //retornar respuesta
        return response()->json(["mensaje" => "Articulo Actualizado"], 200);

    }
}
