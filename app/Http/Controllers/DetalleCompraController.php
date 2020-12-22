<?php

namespace App\Http\Controllers;

use App\models\Compra;
use App\models\Detalle_Compra;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DetalleCompraController extends Controller
{
    /**
     * Consultar todas las compras
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        //realizar consulta        
        $data = Detalle_Compra::where('compra_id',$request->id)->get();
        
        //resultados
        return $data;
    }



    /**
     * Almacenar compra y detalles de las compras
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

        //ingresar una compra
        $compra = new Compra();
        $fecha = Carbon::now('America/Bogota');

        $compra->tipo_comprobante = $request->tipo_comprobante;
        $compra->serie_comprobante = $request->serie_comprobante;
        $compra->numero_comprobante = $request->numero_comprobante;
        $compra->fecha_hora = $fecha->toDateTimeString();
        $compra->impuesto = $request->impuesto;
        $compra->total = $request->total;
        $compra->estado = 'Registrada';
        $compra->proveedor_id = $request->proveedor_id;
        $compra->user_id = auth()->user()->id;
        $compra->save();

        //ingresar los detalles de la compra
        $arrayDetalles = $request->arrayDetalles;
        foreach ($arrayDetalles as $key => $value) {

            $detalle_compra = new Detalle_Compra();
            $detalle_compra->cantidad = $value['cantidad'];
            $detalle_compra->precio = $value['precio'];
            $detalle_compra->compra_id = $compra->id;
            $detalle_compra->articulo_id = $value['articulo_id'];
            $detalle_compra->save();
        }

        return response()->json(["mensaje" => "Compra Registrada"], 200);

        //Trigger cuando se inserta una compra

        // DELIMITER //
        // CREATE TRIGGER upDateStock AFTER insert ON detalle__compras
        // for each row begin
        // update articulos set stock = stock + NEW.cantidad
        // where articulos.id = NEW.articulo_id;
        // end
        // //
        // DELIMITER ;

        //Triger cuando se anula una compra
        // DELIMITER //
        // create trigger upDateAnular after update on compras for each row
        // begin 
        // update 	articulos
        // join 	detalle_compras
        // on   	detalle_compras.articulo_id = articulos.id
        // and  	detalle_compras.compra_id = new.id
        // set	 	articulos.stock = articulos - detalle_compras.cantidad;
        // end;
        // //
        // DELIMITER ;



    }

    /**
     * Anular una compra
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //verificar que sean peticiones ajax
        if (!$request->ajax()) return redirect('/');

        $compra = Compra::findOrFail($request->id);
        $compra->estado = 'Anulada';
        $compra->save();

        return response()->json(["mensaje" => "Compra Anulada"], 200);
    }
}
