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



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/enviarSolicitud','ProfesionalController@enviarSolicitud')->name('enviar.solicitud');
Route::get('/obtenerProfesional/{rut}','ProfesionalController@obtenerProfesional')->name('obtener.profesional');
Route::get('/profesional','ProfesionalController@index')->name('profesional.index');

route::get('/live_search/nacionalidades', 'LiveSearchController@getNacionalidades')->name('live_search.nacionalidades');
route::get('/live_search/profesiones', 'LiveSearchController@getProfesiones')->name('live_search.profesiones');
route::get('/live_search/especialidades', 'LiveSearchController@getEspecialidades')->name('live_search.especialidades');

route::get('/reclutador', 'ReclutadorController@index')->name('reclutador.index');
route::get('/callcenter', 'CallCenterController@index')->name('callcenter.index');
route::get('/callcenter/verinfo/{id}', 'CallCenterController@verInfo')->name('callcenter.verinfo');
