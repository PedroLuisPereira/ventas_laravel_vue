<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function articulos()
    {
        return $this->hasMany('App\models\Articulo');
    }
}
