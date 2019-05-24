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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('users', 'UserController@index');
        Route::get('users/{uid}', 'UserController@show')->where(['uid' => '[0-9]+']);
        Route::get('users/create', 'UserController@create');
        Route::post('users/create', 'UserController@store');
        Route::get('users/{uid}/edit', 'UserController@edit')->where(['uid' => '[0-9]+']);
        Route::post('users/{uid}/edit', 'UserController@update')->where(['uid' => '[0-9]+']);
        Route::post('users/{uid}/delete', 'UserController@destroy')->where(['uid' => '[0-9]+']);

        Route::get('categorias', 'CategoriaController@index')->name('indice');

        Route::get('categorias/create','CategoriaController@create');
        Route::post('categorias/create', 'CategoriaController@store');

        Route::get('configurations/edit', 'Configurations@edit');
        Route::post('configurations/edit', 'Configurations@update');

        Route::get('upload', 'ConteudoController@create');
        Route::post('upload', 'ConteudoController@store');
        Route::get('uploads/{cid}/edit', 'ConteudoController@edit');
        Route::post('uploads/{cid}/edit', 'ConteudoController@update');

        Route::get('categorias/{cid}', 'CategoriaController@show')->where(['uid' => '[0-9]+']);
        Route::get('categorias/{cid}/edit', 'CategoriaController@edit')->where(['uid' => '[0-9]+']);;
        Route::post('categorias/{cid}/edit', 'CategoriaController@update')->where(['uid' => '[0-9]+']);
        Route::post('categorias/{cid}/delete', 'CategoriaController@destroy')->where(['uid' => '[0-9]+']);
        Route::get('users/{uid}/subscribe','UserController@subscribe')->where(['uid' => '[0-9]+']);

        Route::get('configurations/edit', 'Configurations@edit');
    });

    Route::group(['middleware' => 'role:user'], function() {
        Route::get('profile', function (\App\Http\Controllers\UserController $controller) {
            $uid = Auth::user()->id;
            return $controller->show($uid);
        });

        /*Route::get('upload', 'ConteudoController@create');
        Route::post('upload', 'ConteudoController@store');*/
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