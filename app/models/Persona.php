<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    protected $fillable =['nombre','tipo_documento','nume_documento','direccion','telefono','email'];

    public function proveedor(){
        //una persona puede ser proveedor
        return $this->hasOne('App\models\Proveedor');
    }
}
