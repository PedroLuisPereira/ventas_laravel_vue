<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{   
    //campos que recibe informacion 
    protected $fillable = ['tipo_comprobante', 'serie_comprobante', 'numero_comprobante', 'fecha_hora', 'impuesto', 'total', 'estado', 'proveedor_id', 'user_id'];

    public function user(){
        return $this->belongsTo('App\models\User');
    }

    public function proveedor(){
        return $this->belongsTo('App\models\Proveedor');
    }
}
