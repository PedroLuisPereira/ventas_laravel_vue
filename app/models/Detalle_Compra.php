<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Detalle_Compra extends Model
{
    //cantidad int(11) 
    protected $fillable = ['cantidad', 'precio', ' compra_id', 'articulo_id'];
}
