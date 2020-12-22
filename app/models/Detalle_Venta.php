<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    //cantidad int(11) 
    protected $fillable = ['cantidad', 'precio','descuento', ' compra_id', 'articulo_id'];
}
