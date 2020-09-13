<?php

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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AdminController@spa_index')->name('admin');
// Route::get('/', 'AdminController@index')->name('admin');
// Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin', 
    'namespace' => 'Admin', 
    'middleware' => 'auth'], function(){
    Route::resource('categorias', 'CategoriesController');
    Route::resource('divisa', 'DivisaController');
    Route::resource('productos', 'ProductsController');
    Route::resource('ingresos', 'IncomesController');
    Route::resource('proveedores', 'ProvidersController');
    Route::resource('ventas', 'SalesController');
    Route::resource('clientes', 'CustomersController');
});

Auth::routes();

