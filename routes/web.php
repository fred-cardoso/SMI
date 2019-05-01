<?php

use \App\Http\Controllers;

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

Route::get('categorias', 'CategoriaController@index')->name('indice');
Route::get('categorias/create','CategoriaController@create');
Route::get('categorias/{cid}', 'CategoriaController@show');
Route::post('categorias/create', 'CategoriaController@store');

Route::get('/', function () {
    return view('welcome');
});
