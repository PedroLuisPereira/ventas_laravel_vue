<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    public function categoria()
    {
        return $this->belongsTo('App\models\Categoria');
    }
}
