<?php

//use \App\Http\Controllers;
use Illuminate\Http\Request;

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

Auth::routes(['verify' => true]);

dd(auth()->user());

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('users', 'UserController@index');
        Route::get('users/{uid}', 'UserController@show');
        Route::get('users/create', 'UserController@show');

        Route::get('categorias', 'CategoriaController@index')->name('indice');
        Route::get('categorias/create','CategoriaController@create');
        Route::get('categorias/{cid}', 'CategoriaController@show');
        Route::post('categorias/create', 'CategoriaController@store');
    });

   // dd($request);

    Route::group(['middleware' => 'role:user'], function() {

        dd(Auth::user());

        Route::get('users/{uid}', 'UserController@show')->where('uid', Auth::user()->id);
    });

});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Example
 */

/*Route::group(['middleware' => 'role:admin'], function() {
    Route::get('/admin', function() {
        return 'Welcome Admin';
    });
})->middleware('verified');*/