<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Table\Table;

class Categorias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('categorias')->insert(
            [
                'nombre' => "Vinos",
                'descripcion' => 'Son vinos',
                'condicion' => '1'
            ],

            [
                'nombre' => "pan",
                'descripcion' => 'Son panes',
                'condicion' => '1'
            ],


        );
    }
}
