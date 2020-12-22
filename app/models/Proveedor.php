<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //un proveedor pertenece a una persona
    public function persona(){
        //retornar modelo persona
        return $this->belongsTo('App\models\Persona');
    }
}
