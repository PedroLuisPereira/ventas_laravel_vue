<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/prueba', 'PruebaController@index')->middleware('administrador');
Route::get('/prueba', 'PruebaController@index')->middleware('vendedor');
//Route::get('/prueba', 'PruebaController@index')->middleware('almacenista');



Route::get('/', function () {
    return view('welcome');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//rutas de las categorias
Route::resource('/categoria', 'CategoriaController');
Route::get('/categorialistar', 'CategoriaController@listar');

//rutas de las articulos
Route::resource('/articulo', 'ArticuloController');
Route::get('/consultarArticulo', 'ArticuloController@consultarArticulo');

//rutas de persona
Route::resource('/persona', 'PersonaController');

//rutas de proveedor
Route::resource('/proveedor', 'ProveedorController');
Route::get('/listarProveedores', 'ProveedorController@listarProveedores');

//rutas de rol
Route::resource('/rol', 'RolController');
Route::get('/consultarrol', 'RolController@consultarrol');

//rutas de usuario
Route::resource('/usuario', 'UserController');

//rutas de compra
Route::resource('/compra', 'CompraController');

//rutas de detalle compra
Route::resource('/detallecompra', 'DetalleCompraController');

//rutas de venta
Route::resource('/venta', 'VentaController');

//rutas de detalle venta
Route::resource('/detalleventa', 'DetalleVentaController');


