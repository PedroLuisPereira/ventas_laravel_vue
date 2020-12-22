<?php

namespace App\Http\Controllers;

use App\models\Articulo;
use Illuminate\Http\Request;
use App\models\Categoria;
use App\models\Persona;
use App\models\Proveedor;
use Illuminate\Support\Facades\DB;

class PruebaController extends Controller
{

    public function index(Request $request)
    {


        $users = DB::table('articulos')->select()
            ->join('categorias', 'categorias.id', '=', 'articulos.categoria_id')
            ->get();

        $results = DB::select("select * from articulos,categorias where categorias.id = articulos.categoria_id;");
        return $results;
    }

    public function relaciones()
    {

        $phone = Categoria::find(5)->articulos;
        return $phone;
    }

    public function eloquent(Request $request)
    {
        //consultar todos
        $flights = Categoria::all();

        //consultar con condiciones
        $flights = Categoria::where('condicion', 1)
            ->orderBy('nombre', 'desc')
            ->take(10)
            ->get();

        //refrescar el modelo
        $freshFlight = $flights->fresh();

        //estos métodos devuelven una única instancia de modelo:
        // Recupera un modelo por su clave primaria...
        $flight1 = Categoria::find(1);

        // Recupera el primer modelo que coincida con las restricciones de consulta...
        $flight2 = Categoria::where('condicion', 1)->first();

        // Shorthand for retrieving the first model matching the query constraints...
        $flight3 = Categoria::firstWhere('condicion', 1);

        //si no se encuetra nada una excepcion es arrojada
        $model = Categoria::findOrFail(9);
        //$model = Categoria::where('nombre', '=', 'juna')->firstOrFail();

        //agrupamiento
        $count = Categoria::where('condicion', 1)->count();
        //$max = Categoria::where('active', 1)->max('price');

        //insert
        $flight = new Categoria;
        $flight->nombre = 'nombre';
        $flight->save();

        //update
        $flight = Categoria::find(9);
        $flight->nombre = 'New Flight Name';
        $flight->save();

        //delete
        $flight = Categoria::find(8);
        $flight->delete();
    }

    public function constructorDeConsultas()
    {
        //El método get devuelve una colección de la clase Illuminate\Support\Collection
        $datos = DB::table('categorias')->get();

        //devolver una fila
        $datos = DB::table('categorias')->where('nombre', 'farmarcia 3')->first();

        //un campo
        $email = DB::table('categorias')->where('nombre', 'farmarcia 3')->value('nombre');

        //buscar por id
        $user = DB::table('categorias')->find(3);

        //obtener una colleccion de toda la columna
        $titles = DB::table('categorias')->pluck('nombre');

        //agrupamientos
        $users = DB::table('categorias')->count();
        //$price = DB::table('categorias')->max('id');

        //ver si existen registros
        echo DB::table('categorias')->where('condicion', 1)->exists();

        echo DB::table('categorias')->where('condicion', 1)->doesntExist();


        //seleccionar algunas columnas
        $users = DB::table('categorias')->select('nombre', 'condicion as user_email')->get();

        //inner join
        $union = DB::table('articulos')
            ->join('categorias', 'articulos.categoria_id', '=', 'categorias.id')
            ->select('articulos.*', 'categorias.nombre')
            ->get();

        //where
        $users = DB::table('categorias')->where('id', '=', 100)->get();
        $users = DB::table('categorias')->where('id', 100)->get();
        $users = DB::table('users')->where([
            ['id', '=', '1'],
            ['condicion', '<>', '1'],
        ])->get();

        $users = DB::table('categorias')
            ->where('id', '>', 100)
            ->orWhere('nombre', 'John')
            ->get();

        //ordenamiento
        $users = DB::table('categorias')
            ->orderBy('nombre', 'desc')
            ->get();

        //insert
        DB::table('categorias')->insert(
            ['nombre' => 'john@example.com', 'condicion' => 0]
        );
        DB::table('categorias')->insert([
            ['nombre' => 'taylor@example.com', 'condicion' => 0],
            ['nombre' => 'dayle@example.com', 'condicion' => 0]
        ]);
        //devuelve el id
        $id = DB::table('categorias')->insertGetId(
            ['nombre' => 'john@example.com', 'condicion' => 0]
        );

        //actualizar
        $affected = DB::table('categorias')
            ->where('id', 10)
            ->update(['condicion' => 0]);

        DB::table('categorias')
            ->updateOrInsert(
                ['nombre' => 'john@example.com', 'descripcion' => 'John'],
                ['nombre' => '2']
            );

        //delete
        DB::table('categorias')->where('id', '=', 10)->delete();
        print_r($id);
    }


    public function consultasNativas()
    {

        //devuelve un arra y de objetos
        $datos = DB::select('select * from categorias where condicion = ?', [1]);

        //enlaces nombrados
        $datos = DB::select('select * from categorias where condicion = :id', ['id' => 1]);

        //insert
        //DB::insert('insert into categorias (id, nombre) values (?, ?)', [1, 'Dayle']);

        //updata
        //$affected = DB::update("update categorias set nombre = 'juan' where nombre = ?", ['Dayle']);

        //eliminar
        $deleted = DB::delete('delete from categorias where nombre = ?', ['juan']);

        //transaccion 
        DB::transaction(function () {
            DB::insert('insert into categorias (id, nombre) values (?, ?)', [1, 'Dayle']);
            $affected = DB::update("update categorias set nombre = 'juan' where nombre = ?", ['juan']);
        });

        print_r($datos);
    }
}
