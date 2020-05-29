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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/profesional', function () {
    return view('profesional');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/enviarSolicitud','ProfesionalController@enviarSolicitud')->name('enviar.solicitud');
Route::get('/obtenerProfesional/{rut}','ProfesionalController@obtenerProfesional')->name('obtener.profesional');

route::get('/live_search/nacionalidades', 'LiveSearchController@getNacionalidades')->name('live_search.nacionalidades');
