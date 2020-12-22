<?php

namespace App\Http\Controllers;

use App\models\Venta;
use App\models\Detalle_Venta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentaController extends Controller
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
        $data = Venta::all();


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
        $venta = new Venta();
        $fecha = Carbon::now('America/Bogota');

        //registrar los datos
        $venta->tipo_comprobante = $request->tipo_comprobante;
        $venta->serie_comprobante = $request->serie_comprobante;
        $venta->numero_comprobante = $request->numero_comprobante;
        $venta->fecha_hora = $fecha->toDateTimeString();
        $venta->impuesto = $request->impuesto;
        $venta->total = $request->total;
        $venta->estado = 'Registrada';
        $venta->persona_id = $request->persona_id;
        $venta->user_id = auth()->user()->id;
        $venta->save();

        //ingresar los detalles de la compra
        $arrayDetalles = $request->arrayDetalles;
        foreach ($arrayDetalles as $key => $value) {

            $detalle_venta = new Detalle_Venta();
            $detalle_venta->cantidad = $value['cantidad'];
            $detalle_venta->precio = $value['precio'];
            $detalle_venta->descuento = 0;
            $detalle_venta->venta_id = $venta->id;
            $detalle_venta->articulo_id = $value['articulo_id'];
            $detalle_venta->save();
        }

        return response()->json(["mensaje" => "Venta Registrada"], 200);

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

        $compra = Venta::findOrFail($request->id);
        $compra->estado = 'Anulada';
        $compra->save();

        return response()->json(["mensaje" => "Venta Anulada"], 200);
    }
}

