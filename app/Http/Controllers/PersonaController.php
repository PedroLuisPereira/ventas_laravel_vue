<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Persona;

class PersonaController extends Controller
{
    /**
     * Consultar todas las personas
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar consulta
        $personas = Persona::where('id', 'like', '%' . $request->buscar . '%')
            ->orWhere('nombre', 'like', '%' . $request->buscar . '%')
            ->orWhere('nombre', 'like', '%' . $request->buscar . '%')
            ->orWhere('tipo_documento', 'like', '%' . $request->buscar . '%')
            ->orWhere('numero_documento', 'like', '%' . $request->buscar . '%')
            ->orWhere('direccion', 'like', '%' . $request->buscar . '%')
            ->orWhere('telefono', 'like', '%' . $request->buscar . '%')
            ->orWhere('email', 'like', '%' . $request->buscar . '%')
            ->get();

        //retornar respuesta
        return $personas;
    }



    /**
     * Crear una nueva persona
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar las validaciones
        //****************************** */

        //crear nueva pesona
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();

        //Retornar respuesta
        return response()->json(["mensaje" => "Persoana Registrada"], 200);
    }

    

    /**
     * Actualizar las personas 
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
        /********************* */

        //buscar el objeto 
        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->save();

        //retornar respuesta
        return response()->json(["mensaje" => "Persona Actualizada"], 200);
    }

}
