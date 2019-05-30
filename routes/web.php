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
})->name('home');

Route::get('uploads', 'ConteudoController@index')->name('uploads');
Route::get('uploads/{conteudo}', 'ConteudoController@show')->where(['conteudo' => '[0-9]+'])->name('uploads.show');

Route::get('categorias', 'CategoriaController@index')->name('categorias');
Route::get('categorias/{categoria}', 'CategoriaController@show')->where(['categoria' => '[0-9]+']);

Route::get('users', 'UserController@index')->name('users');
Route::get('users/{user}', 'UserController@show')->where(['user' => '[0-9]+'])->name('user');

Route::group(['middleware' => ['auth', 'verified', 'role:user']], function () {
    /**
     * User basic Routes
     */
    Route::get('uploads/media/{path}', function ($path) {

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
    })->name('media');

    Route::get('profile', function (\App\Http\Controllers\UserController $controller) {
        return $controller->show(Auth::user());
    })->name('profile');
    Route::post('profile/edit', function (\App\Http\Controllers\UserController $controller) {
        return $controller->updateProfile(Auth::user(), request());
    })->name('profile_edit');

    Route::post('users/{user}/subscribe', 'UserController@subscribeUser')->where(['user' => '[0-9]+'])->name('user.subscribe');
    Route::post('users/{categoria}/subscribeCat', 'UserController@subscribeCategoria')->where(['categoria' => '[0-9]+'])->name('cat.subscribe');

    Route::post('categorias/{categoria}/subscribe', 'UserController@subscribeCategoria')->where(['categoria' => '[0-9]+']);
    /**
     * Routes for "Simpatizante"
     */
    Route::group(['middleware' => 'role:simpatizante'], function () {
        Route::get('categorias/create', 'CategoriaController@create');
        Route::post('categorias/create', 'CategoriaController@store');
        Route::get('categorias/{categoria}/edit', 'CategoriaController@edit')->where(['categoria' => '[0-9]+'])->name('cat.edit');
        Route::post('categorias/{categoria}/edit', 'CategoriaController@update')->where(['categoria' => '[0-9]+']);

        Route::get('upload', 'ConteudoController@create')->name('upload');
        Route::post('upload', 'ConteudoController@store');
        Route::get('uploads/{conteudo}/edit', 'ConteudoController@edit')->where(['conteudo' => '[0-9]+'])->name('uploads.edit');
        Route::post('uploads/{conteudo}/edit', 'ConteudoController@update')->where(['conteudo' => '[0-9]+']);

        /**
         * Routes for admin
         */
        Route::group(['middleware' => 'role:admin'], function () {
            Route::get('users/create', 'UserController@create')->name('users.create');
            Route::post('users/create', 'UserController@store');

            Route::get('users/{user}/edit', 'UserController@edit')->where(['user' => '[0-9]+'])->name('user.edit');
            Route::post('users/{user}/edit', 'UserController@update')->where(['user' => '[0-9]+']);
            Route::post('users/{user}/delete', 'UserController@destroy')->where(['user' => '[0-9]+'])->name('user.delete');

            Route::get('configurations/edit', 'ConfigurationsController@edit')->name('config');
            Route::post('configurations/edit', 'ConfigurationsController@update');

            Route::post('uploads/{conteudo}/delete', 'ConteudoController@destroy')->where(['conteudo' => '[0-9]+'])->name('uploads.delete');

            Route::post('categorias/{categoria}/delete', 'CategoriaController@destroy')->where(['categoria' => '[0-9]+']);
        });
    });
});