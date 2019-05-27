<?php

use Illuminate\Support\Facades\Storage;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'verified', 'role:user']], function () {
    /**
     * User basic Routes
     */
    Route::get('uploads/video/{path}', function ($path) {

        $file = null;

        try {
            $file = Storage::get("files/" . $path);
        } catch (Exception $exception) {
            abort(404);
        }

        $filename = storage_path() . "files/" . $path;
        $headers = array(
            'Content-type' => Storage::mimeType("files/" . $path),
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        );
        return Response::make($file, 200, $headers);
    })->name('video');

    Route::get('profile', function (\App\Http\Controllers\UserController $controller) {
        dd("teste");
        $uid = Auth::user()->id;
        return $controller->show($uid);
    });

    /**
     * Routes for "Simpatizante"
     */
    Route::group(['middleware' => 'role:simpatizante'], function () {



        /**
         * Routes for admin
         */
        Route::group(['middleware' => 'role:admin'], function () {
            Route::get('users', 'UserController@index')->name('users');
            Route::get('users/{user}', 'UserController@show')->where(['uid' => '[0-9]+'])->name('user');
            Route::get('users/create', 'UserController@create');
            Route::post('users/create', 'UserController@store');
            Route::get('users/{user}/edit', 'UserController@edit')->where(['uid' => '[0-9]+'])->name('user_edit');
            Route::post('users/{user}/edit', 'UserController@update')->where(['uid' => '[0-9]+']);
            Route::post('users/{user}/delete', 'UserController@destroy')->where(['uid' => '[0-9]+']);

            Route::get('categorias', 'CategoriaController@index')->name('indice');

            Route::get('categorias/create', 'CategoriaController@create');
            Route::post('categorias/create', 'CategoriaController@store');

            Route::get('configurations/edit', 'Configurations@edit');
            Route::post('configurations/edit', 'Configurations@update');

            Route::get('uploads', 'ConteudoController@index');
            Route::get('upload', 'ConteudoController@create');
            Route::post('upload', 'ConteudoController@store');
            Route::get('uploads/{conteudo}', 'ConteudoController@show')->where(['conteudo' => '[0-9]+']);;
            Route::get('uploads/{conteudo}/edit', 'ConteudoController@edit')->where(['conteudo' => '[0-9]+']);;
            Route::post('uploads/{conteudo}/edit', 'ConteudoController@update')->where(['conteudo' => '[0-9]+']);;
            Route::post('uploads/{conteudo}/delete', 'ConteudoController@destroy')->where(['conteudo' => '[0-9]+']);;

            Route::get('categorias/{categoria}', 'CategoriaController@show')->where(['categoria' => '[0-9]+']);
            Route::get('categorias/{categoria}/edit', 'CategoriaController@edit')->where(['categoria' => '[0-9]+']);;
            Route::post('categorias/{categoria}/edit', 'CategoriaController@update')->where(['categoria' => '[0-9]+']);
            Route::post('categorias/{categoria}/delete', 'CategoriaController@destroy')->where(['categoria' => '[0-9]+']);
            Route::post('users/{user}/subscribe', 'UserController@subscribe')->where(['user' => '[0-9]+']);

            Route::get('configurations/edit', 'Configurations@edit');
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');