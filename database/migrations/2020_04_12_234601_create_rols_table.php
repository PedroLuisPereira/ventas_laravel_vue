<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',30)->unique();
            $table->string('descripcion',100)->nullable();
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });

        DB::table('rols')->insert(array('id'=>1,'nombre'=>'Administrador','descripcion'=>'Administrador de área','condicion'=>1));
        DB::table('rols')->insert(array('id'=>2,'nombre'=>'Vendedor','descripcion'=>'Area de venta','condicion'=>1));
        DB::table('rols')->insert(array('id'=>3,'nombre'=>'Almacenero','descripcion'=>'Area de Almacen','condicion'=>1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
