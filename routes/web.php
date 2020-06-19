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
    return view('index');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



route::group(['middleware' => 'auth'], function () {

    Route::post('/enviarSolicitud', 'ProfesionalController@enviarSolicitud')->name('enviar.solicitud');
    Route::get('/obtenerProfesional/{rut}', 'ProfesionalController@obtenerProfesional')->name('obtener.profesional');
    Route::get('/profesional', 'ProfesionalController@index')->name('profesional.index');
    Route::get('/profesional_edit/{id}', 'ProfesionalController@edit')->name('profesional.edit');
    Route::post('/profesional_edit', 'ProfesionalController@update')->name('profesional.update');
    route::get('/user_change/{id}','UserController@getCambiarPassword')->name('user.cambiar');
    route::post('/user/change','UserController@cambiarPassword')->name('user.cambiarpassword');

    route::get('/live_search/nacionalidades', 'LiveSearchController@getNacionalidades')->name('live_search.nacionalidades');
    route::get('/live_search/profesiones', 'LiveSearchController@getProfesiones')->name('live_search.profesiones');
    route::get('/live_search/especialidades', 'LiveSearchController@getEspecialidades')->name('live_search.especialidades');
    route::get('/live_search/comunas', 'LiveSearchController@getComunas')->name('live_search.comunas');
    route::get('/live_search/establecimientos', 'LiveSearchController@getEstablecimientos')->name('live_search.establecimientos');
    route::get('/live_search/servicio', 'LiveSearchController@getServicio')->name('live_search.servicio');

    route::get('/reclutador', 'ReclutadorController@index')->name('reclutador.index');
    Route::post('/crearSolicitud', 'ReclutadorController@crearSolicitud')->name('reclutador.crearSolicitud');
    route::get('/nuevaSolicitud', 'ReclutadorController@nuevaSolicitud')->name('reclutador.nuevaSolicitud');
    Route::get('/reclutador/verinfo/{id}', 'ReclutadorController@verSolicitud')->name('reclutador.verSolicitud');
    Route::get('/reclutador/eliminarSolicitud/{id}', 'ReclutadorController@modalEliminarSolicitud')->name('reclutador.modalEliminarSolicitud');
    Route::post('/reclutador/eliminarSolicitud', 'ReclutadorController@eliminarSolicitud')->name('reclutador.eliminarSolicitud');

    route::get('/callcenter', 'CallCenterController@index')->name('callcenter.index');
    route::get('/callcenter/verinfo/{id}', 'CallCenterController@verInfo')->name('callcenter.verinfo');
    route::get('/callcenter/asignarProfesional/{id}', 'CallCenterController@asignarProfesional')->name('callcenter.asignarProfesional');
    route::get('/callcenter/complementarProfesional/{id}', 'CallCenterController@complementarProfesional')->name('callcenter.complementarProfesional');

    route::post('/enviarComplementar', 'CallCenterController@complementarProfesionalEnviar')->name('callcenter.complementarProfesionalEnviar');
    Route::post('/enviarAsignacion', 'AsignacionController@guardar')->name('asignacion.guardar');


    route::get('/descargar_certificado/{id}', 'DescargarDocumentosController@certificadoTitulo')->name('descargar.certificado');
    route::get('/descargar_cedula/{id}', 'DescargarDocumentosController@cedulaIdentidad')->name('descargar.cedula');
    route::get('/descargar_curriculum/{id}', 'DescargarDocumentosController@curriculum')->name('descargar.curriculum');
    route::get('/descargar_capacitacion/{id}', 'DescargarDocumentosController@capacitacion')->name('descargar.capacitacion');

    route::get('/admin/index','AdministradorController@index')->name('admin.index');
    route::get('/admin_edit/{id}','AdministradorController@edit')->name('admin.edit');
    route::post('/admin/update','AdministradorController@update')->name('admin.update');
});
