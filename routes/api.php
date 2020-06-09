<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('dashboard', 'DashboardController');

Route::get('usuarios', 'Admin\UsersController@index');
Route::post('usuario', 'Admin\UsersController@store');
Route::put('usuario/{usuario}', 'Admin\UsersController@update');

Route::get('divisas', 'Admin\DivisaController@index');
Route::get('divisa/price', 'Admin\DivisaController@last_divisa');
Route::post('divisas', 'Admin\DivisaController@store');
Route::put('divisa/{divisa}', 'Admin\DivisaController@update');

Route::get('categorias', 'Admin\CategoriesController@index');
Route::post('categoria', 'Admin\CategoriesController@store');
Route::put('categoria/{id}', 'Admin\CategoriesController@update');
Route::get('categoria/restore/{id}', 'Admin\CategoriesController@restore');
Route::delete('categoria/{id}', 'Admin\CategoriesController@destroy');

Route::get('productos', 'Admin\ProductsController@index');
Route::post('producto', 'Admin\ProductsController@store');
Route::put('producto/{id}', 'Admin\ProductsController@update');
Route::get('producto/{id}', 'Admin\ProductsController@show');
Route::get('producto/restore/{id}', 'Admin\ProductsController@restore');
Route::delete('producto/eliminar/{id}', 'Admin\ProductsController@destroy');


Route::get('proveedores', 'Admin\ProvidersController@index');
Route::post('proveedor', 'Admin\ProvidersController@store');
Route::put('proveedor/{id}', 'Admin\ProvidersController@update');
Route::get('proveedor/{id}', 'Admin\ProvidersController@show');
Route::get('proveedor/restore/{id}', 'Admin\ProvidersController@restore');
Route::delete('proveedor/eliminar/{id}', 'Admin\ProvidersController@destroy');

Route::get('clientes', 'Admin\CustomersController@index');
Route::post('cliente', 'Admin\CustomersController@store');
Route::put('cliente/{id}', 'Admin\CustomersController@update');
Route::get('cliente/{id}', 'Admin\CustomersController@show');
Route::get('cliente/restore/{id}', 'Admin\CustomersController@restore');
Route::delete('cliente/eliminar/{id}', 'Admin\CustomersController@destroy');