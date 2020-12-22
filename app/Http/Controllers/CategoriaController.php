<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Cosultar los datos de la tabla categorias 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //verificar tipo de solicitud
        if (!$request->ajax()) return redirect('/');
        
        //realzar la consulta
        $categorias = Categoria::where('nombre', 'like', '%' . $request->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $request->buscar . '%')
            ->paginate(5);
        
        //retornar dos array asociativo
        return [
            'paginate' => [
                'total' => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page' => $categorias->perPage(),
                'last_page' => $categorias->lastPage(),
                'from' => $categorias->firstItem(),
                'to' => $categorias->lastPage(),
            ],
            'categorias' => $categorias

        ];
    }

    /**
     * Cosultar las categorias que están activas 
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {
        if ($request->ajax()) {
            //listar categorias activas 
            $categorias = Categoria::where('condicion', '=', '1')->get();
            return $categorias;
        } else {
            return redirect('/');
        }
    }


    
    /**
     * Crear un nuevo registro de categorias 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar validaciones
        /*********************** */

        //crear el objeto y llenar los datos 
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = 1;
        $categoria->save();

        //retornar respuesta
        return response()->json([
            "mensaje" => "Categoria registrada"
        ], 200);
    }


    /**
     * Actualizar un registro 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');
        
        // ralizar validaciones 
        /******************************** */

        //buscar el registro si no lo encuentra lanza una excepcion 440
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = 1;
        $categoria->save();

        //retornar respuesta
        return response()->json([
            "mensaje" => "Categoria actualizada"
        ], 200);
    }

    /**
     * Activar o desactivar una categoría 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar la el cambio 
        $categoria = Categoria::findOrFail($request->id);
        if ($categoria->condicion == 1) {
            $categoria->condicion = 0;
        } else {
            $categoria->condicion = 1;
        }

        //actualizar el cambio 
        $categoria->save();

        //retornar respuesta
        return response()->json(["mensaje" => "Articulo Actualizado"], 200);
    }
}
