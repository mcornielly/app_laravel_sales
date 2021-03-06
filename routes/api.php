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

// Dashboard
Route::get('dashboard', 'DashboardController');


// Usuarios
Route::get('usuarios', 'Admin\UsersController@index');
Route::post('usuario', 'Admin\UsersController@store');
Route::put('usuario/{usuario}', 'Admin\UsersController@update');


// Divisas
Route::get('divisas', 'Admin\DivisaController@index');
Route::get('divisa/precio', 'Admin\DivisaController@price_divisa');
Route::post('divisas', 'Admin\DivisaController@store');
Route::put('divisa/{divisa}', 'Admin\DivisaController@update');

// Categorías
Route::get('categorias', 'Admin\CategoriesController@index');
Route::post('categoria', 'Admin\CategoriesController@store');
Route::put('categoria/{id}', 'Admin\CategoriesController@update');
Route::get('categoria/restore/{id}', 'Admin\CategoriesController@restore');
Route::delete('categoria/{id}', 'Admin\CategoriesController@destroy');
Route::get('categorias/lista', 'Admin\CategoriesController@list_categories');

// Productos
Route::get('productos', 'Admin\ProductsController@index');
Route::get('productos/lista_precios', 'Admin\ProductsController@price_list');
Route::post('producto', 'Admin\ProductsController@store');
Route::put('producto/{id}', 'Admin\ProductsController@update');
Route::get('producto/{id}', 'Admin\ProductsController@show');
Route::get('producto/restore/{id}', 'Admin\ProductsController@restore');
Route::delete('producto/eliminar/{id}', 'Admin\ProductsController@destroy');
Route::post('producto/img', 'Admin\PhotosController@store');
Route::get('producto/imagenes/{id}', 'Admin\PhotosController@show');
Route::get('producto/search/{code}', 'Admin\ProductsController@product_search');
Route::post('producto/validate', 'Admin\ProductsController@validate_step');
Route::post('producto/validate/code', 'Admin\ProductsController@validate_code');
Route::put('producto/actualizar_costo/{id}', 'Admin\ProductsController@update_cost');

// Fotos-Imagenes del Producto
Route::post('fotos/url', 'Admin\PhotosController@delete_storage');
Route::delete('fotos/eliminar/{id}', 'Admin\PhotosController@destroy');

// Proveedores
Route::get('proveedores', 'Admin\ProvidersController@index');
Route::post('proveedor', 'Admin\ProvidersController@store');
Route::put('proveedor/{id}', 'Admin\ProvidersController@update');
Route::get('proveedor/{id}', 'Admin\ProvidersController@show');
Route::get('proveedor/restore/{id}', 'Admin\ProvidersController@restore');
Route::delete('proveedor/eliminar/{id}', 'Admin\ProvidersController@destroy');
Route::get('seleccionar-proveedor', 'Admin\ProvidersController@select_provider');

// Ingresos
Route::get('ingresos', 'Admin\IncomesController@index');
Route::post('ingreso', 'Admin\IncomesController@store');
// Route::get('ingreso/{id}', 'Admin\IncomesController@show');
Route::get('ingresos/num_factura', 'Admin\IncomesController@count_record');
Route::get('ingreso/detalles/{id}', 'Admin\IncomesController@get_detail');
Route::get('ingreso/pdf/{id}', 'Admin\IncomesController@income_pdf');
Route::delete('ingreso/anular/{id}', 'Admin\IncomesController@destroy');

// Clientes
Route::get('clientes', 'Admin\CustomersController@index');
Route::post('cliente', 'Admin\CustomersController@store');
Route::put('cliente/{id}', 'Admin\CustomersController@update');
Route::get('cliente/{id}', 'Admin\CustomersController@show');
Route::get('cliente/restore/{id}', 'Admin\CustomersController@restore');
Route::delete('cliente/eliminar/{id}', 'Admin\CustomersController@destroy');
Route::get('seleccionar-cliente', 'Admin\CustomersController@select_customer');

Route::get('ventas', 'Admin\SalesController@index');
Route::post('venta', 'Admin\SalesController@store');
Route::get('venta/{id}', 'Admin\SalesController@show');
Route::get('ventas/num_factura', 'Admin\SalesController@count_record');
Route::get('venta/pdf/{id}', 'Admin\SalesController@sale_pdf');
Route::delete('venta/anular/{id}', 'Admin\SalesController@destroy');

