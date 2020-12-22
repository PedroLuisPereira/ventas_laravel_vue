<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Rol;

class RolController extends Controller
{
    /**
     * Consultar los roles
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   //verificar ajax
        if (!$request->ajax()) return redirect('/');

        //realizar consulta
        $datos = Rol::where('id', 'like', '%' . $request->buscar . '%')
            ->orWhere('nombre', 'like', '%' . $request->buscar . '%')
            ->orWhere('descripcion', 'like', '%' . $request->buscar . '%')
            ->orWhere('condicion', 'like', '%' . $request->buscar . '%')
            ->get();
        
        //respuesta
        return $datos;
    }


    /**
     * Consultar los roles activos
     *
     * @return \Illuminate\Http\Response
     */
    public function consultarrol(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');
        
        //listar categorias activas 
        $categorias = Rol::where('condicion', '=', '1')->get();
        return $categorias;
    }
    
}
