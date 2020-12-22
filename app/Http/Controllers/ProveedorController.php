<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Persona;
use App\models\Proveedor;
use Exception;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Realizar consulta
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar consulta
        $data = Persona::select('*')
            ->join('proveedors', 'personas.id', '=', 'proveedors.id')
            ->get();

        //respuesta
        return $data;
    }

    /**
     * Listar todos los proveedores con un filtro
     *
     * @return \Illuminate\Http\Response
     */
    public function listarProveedores(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;

        $proveedores = Proveedor::join('personas', 'proveedors.id', '=', 'personas.id')
            ->where('personas.nombre', 'like', '%' . $filtro . '%')
            ->orWhere('personas.numero_documento', 'like', '%' . $filtro . '%')
            ->select('personas.id', 'personas.nombre', 'personas.numero_documento')
            ->orderBy('personas.nombre', 'asc')
            ->get();

        return ['proveedores'=>$proveedores];

    }

    /**
     * Crear una persona junto con el proveedor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar las validaciones
        //********************** */

        //ingresar una persona
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();


        //ingresar un proveedor
        $proveedor = new Proveedor();
        $proveedor->id = $persona->id;
        $proveedor->contacto = $request->contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->save();

        return response()->json(["mensaje" => "Proveedor Registrado"], 200);
    }


    /**
     * Actualizar un parsona junto con el proveedor
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //validaciones
        /*************** */


        //buscar persoan y proveedor por id
        $proveedor = Proveedor::findOrFail($id);
        $persona = Persona::findOrFail($id);


        //actualizar persona 
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();

        //actualizar proveedor
        $proveedor->contacto = $request->contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->save();


        return response()->json(["mensaje" => "Persona y proveedor Actualizado"], 200);
    }
}
