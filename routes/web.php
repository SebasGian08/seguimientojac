<?php

App::setLocale('es');

Route::get('/', 'App\HomeController@index')->name('index');




Route::get('/loginEmpresa', 'App\HomeController@loginEmpresa')->name('loginEmpresa');
//Route::get('/actualizar', 'App\HomeController@actualizar')->name('actualizar');
Route::get('/filtro_distritos/{id}', 'App\HomeController@filtro_distritos')->name('filtro_distritos');
Route::get('/offline_alumno/{id}', 'App\LoginAlumnoController@offline');

Route::get('/buscar_reniec/{data}', 'App\LoginEmpresaController@consultar_reniec')->name('buscar_reniec');
Route::get('/buscar_sunat/{data}', 'App\LoginEmpresaController@consultar_sunat')->name('buscar_sunat');

Route::group(['middleware' => 'auth:alumnos'], function () {
    Route::group(['prefix' => 'alumno'], function () {

        Route::get('/avisos', 'App\AvisoController@avisos')->name('alumno.avisos');
        Route::get('/{empresa}/informacion', 'App\AvisoController@empresa_informacion')->name('alumno.empresa_informacion');
        Route::get('/{empresa}/aviso/{slug}', 'App\AvisoController@informacion')->name('alumno.informacion');
        Route::post('/aviso/postular', 'App\AvisoController@postular')->name('alumno.postular');

        //Route::group(['middleware' => 'alumno'], function () {});

        Route::get('/perfil', 'App\AlumnoController@index')->name('alumno.perfil');
        Route::post('/perfil', 'App\AlumnoController@store')->name('alumno.store');

        Route::get('/perfil/validacion', 'App\AlumnoController@perfil_validacion')->name('alumno.perfil_validacion');

        Route::get('/perfil/educaciones', 'App\AlumnoController@educaciones')->name('alumno.perfil.educaciones');
        Route::get('/perfil/partialViewEducacion/{id}', 'App\AlumnoController@educacion')->name('alumno.perfil.educacion');
        Route::post('/perfil/educacion', 'App\AlumnoController@educacion_store')->name('alumno.perfil.educacion_store');
        Route::post('/perfil/educacion/delete', 'App\AlumnoController@educacion_delete')->name('alumno.perfil.educacion_delete');

        Route::get('/perfil/experiencias', 'App\AlumnoController@experiencias')->name('alumno.perfil.experiencias');
        Route::get('/perfil/partialViewExperienciaLaboral/{id}', 'App\AlumnoController@experiencia_laboral')->name('alumno.perfil.experiencia_laboral');
        Route::post('/perfil/experiencia', 'App\AlumnoController@experiencia_store')->name('alumno.perfil.experiencia_store');
        Route::post('/perfil/experiencia/delete', 'App\AlumnoController@experiencia_delete')->name('alumno.perfil.experiencia_delete');

        Route::get('/perfil/referencias', 'App\AlumnoController@referencias')->name('alumno.perfil.referencias');
        Route::get('/perfil/partialViewReferenciaLaboral/{id}', 'App\AlumnoController@referencia_laboral')->name('alumno.perfil.referencia_laboral');
        Route::post('/perfil/referencia', 'App\AlumnoController@referencia_store')->name('alumno.perfil.referencia_store');
        Route::post('/perfil/referencia/delete', 'App\AlumnoController@referencia_delete')->name('alumno.perfil.referencia_delete');

        Route::get('/perfil/habilidades', 'App\AlumnoController@habilidades')->name('alumno.perfil.habilidades');
        Route::get('/perfil/partialViewHabilidad/{id}', 'App\AlumnoController@habilidad')->name('alumno.perfil.habilidad');
        Route::get('/perfil/partialViewHabilidadProfesional/{id}', 'App\AlumnoController@habilidad_profesional')->name('alumno.perfil.habilidad_profesional');
        Route::post('/perfil/habilidad', 'App\AlumnoController@habilidad_store')->name('alumno.perfil.habilidad_store');
    });
});


Route::post('empresa/login', 'App\LoginEmpresaController@login')->name('empresa.login.post');
Route::post('empresa/logout', 'App\LoginEmpresaController@logout')->name('empresa.logout');

Route::get('empresa/registrar', 'App\HomeController@crear_empresa')->name('empresa.crear_empresa');
Route::post('empresa/registrar', 'App\HomeController@registrar_empresa')->name('empresa.registrar_empresa.post');

Route::post('alumno/login', 'App\LoginAlumnoController@login')->name('alumno.login.post');
Route::post('alumno/logout', 'App\LoginAlumnoController@logout')->name('alumno.logout');


Route::get('alumno/registrar', 'App\HomeController@crear_alumno')->name('alumno.crear_alumno');
Route::post('alumno/registrar', 'App\HomeController@registrar_alumno')->name('alumno.registrar_alumno.post');

/* ADMINISTRADOR */
Route::get('/home/notification', 'Auth\EmpresaController@notification')->name('auth.home.notification');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:web'], function () {
    Route::get('/home', 'Auth\HomeController@index')->name('auth.index');

    Route::group(['prefix' => 'inicio'], function () {
        Route::get('/', 'Auth\InicioController@index')->name('auth.inicio');
        Route::get('/listSeguimiento', 'Auth\InicioController@listSeguimiento')->name('auth.inicio.listSeguimiento');

    });


    Route::group(['prefix' => 'empresa'], function () {
        Route::get('/', 'Auth\EmpresaController@index')->name('auth.empresa');
        Route::get('/list_all', 'Auth\EmpresaController@list')->name('auth.empresa.list');
        Route::get('/partialView/{id}', 'Auth\EmpresaController@partialView')->name('auth.empresa.create');
        Route::post('/update', 'Auth\EmpresaController@update')->name('auth.empresa.update');
        Route::post('/update_data', 'Auth\EmpresaController@updateData')->name('auth.empresa.update_data');
        Route::post('/delete', 'Auth\EmpresaController@delete')->name('auth.empresa.delete');
    });


    /* Programa Controladores */
    Route::group(['prefix' => 'programa'], function () {      
         Route::get('/', 'Auth\ProgramaController@index')->name('auth.programa');
         Route::post('/store', 'Auth\ProgramaController@store')->name('auth.programa.store');
         Route::get('/list_all', 'Auth\ProgramaController@listAll')->name('auth.programas.listAll');
         Route::post('/updateData', 'Auth\ProgramaController@updateData')->name('auth.programa.updateData');
         Route::get('/partialView/{id}', 'Auth\ProgramaController@partialView')->name('auth.programa.create');
         Route::post('/delete', 'Auth\ProgramaController@delete')->name('auth.programas.delete');
         /* Participantes */
         Route::get('/partialViewParticipantes/{id}', 'Auth\ProgramaController@partialViewParticipantes')->name('auth.programa.partialViewParticipantes');
         Route::post('/storeParticipantes', 'Auth\ProgramaController@storeParticipantes')->name('auth.programa.storeParticipantes');
         Route::get('/mostrarParticipantes', 'Auth\ProgramaController@mostrarParticipantes')->name('auth.programa.mostrarParticipantes');
         Route::post('/deletepar', 'Auth\ProgramaController@deletepar')->name('auth.programas.deletepar');
         Route::get('/partialViewpar/{id}', 'Auth\ProgramaController@partialViewpar')->name('auth.programa.create');
         Route::post('/updateParticipanteInscrito', 'Auth\ProgramaController@updateParticipanteInscrito')->name('auth.programa.updateParticipanteInscrito');

    });



    Route::group(['prefix' => 'area'], function () {
        Route::get('/', 'Auth\AreaController@index')->name('auth.area');
        Route::get('/list_all', 'Auth\AreaController@list_all')->name('auth.area.list_all');
        Route::get('/partialView/{id}', 'Auth\AreaController@partialView')->name('auth.area.create');
        Route::post('/store', 'Auth\AreaController@store')->name('auth.area.store');
        Route::post('/delete', 'Auth\AreaController@delete')->name('auth.area.delete');
    });

    // SECTION USUARIO

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'Auth\UsuariosController@index')->name('auth.usuarios');
        Route::get('/list_all', 'Auth\UsuariosController@list_all')->name('auth.usuarios.list_all');
        Route::post('/store', 'Auth\UsuariosController@store')->name('auth.usuarios.store');
        Route::post('/delete', 'Auth\UsuariosController@delete')->name('auth.usuarios.delete');
        Route::get('/partialView/{id}', 'Auth\UsuariosController@partialView')->name('auth.usuarios.create');
    });

    // END SECTION USUARIO

    Route::group(['prefix' => 'principal'], function () {
        Route::get('/', 'Auth\PrincipalController@index')->name('auth.principal');

    });

    Route::group(['prefix' => 'error'], function () {
        Route::get('/', 'Auth\ErrorController@index')->name('auth.error');

    });

    /* IACYM JAC */
    /* GESTIÓN DE CELULAS */
    Route::group(['prefix' => 'celula'], function () {
        Route::get('/', 'Auth\CelulaController@index')->name('auth.celula');
        Route::get('/list_all', 'Auth\CelulaController@list_all')->name('auth.celula.list_all');
        Route::post('/store', 'Auth\CelulaController@store')->name('auth.celula.store');
        /*  Route::post('/update', 'Auth\EventosAsistenciaController@update')->name('auth.eventosasistencia.update'); */
        Route::post('/delete', 'Auth\CelulaController@delete')->name('auth.celula.delete');
        Route::get('/partialViewAsistentes/{id}', 'Auth\CelulaController@partialViewAsistentes')->name('auth.celula.create');
        Route::get('/mostrarAsistentes', 'Auth\CelulaController@mostrarAsistentes')->name('auth.celula.mostrarAsistentes');
        Route::get('/modalSeguimientoAsistentes/{id}', 'Auth\CelulaController@modalSeguimientoAsistentes')->name('auth.celula.create');
        Route::get('/listSeguimiento', 'Auth\CelulaController@listSeguimiento')->name('auth.celula.listSeguimiento');
        /* Editar */
        Route::get('/partialView/{id}', 'Auth\CelulaController@partialView')->name('auth.celula.create');
        Route::post('/update', 'Auth\CelulaController@update')->name('auth.celula.update');
        /* Seguimiento */
        Route::post('/storeSeguimiento', 'Auth\CelulaController@storeSeguimiento')->name('auth.celula.storeSeguimiento');
        
    });
    Route::group(['prefix' => 'asistentes'], function () {
        Route::get('/', 'Auth\AsistentesController@index')->name('auth.asistentes');
        Route::get('/list_all', 'Auth\AsistentesController@list_all')->name('auth.asistentes.list_all');
        Route::post('/delete', 'Auth\AsistentesController@delete')->name('auth.asistentes.delete');
        Route::post('/store', 'Auth\AsistentesController@store')->name('auth.asistentes.store');
        Route::get('/partialView/{id}', 'Auth\AsistentesController@partialView')->name('auth.asistentes.create');
        Route::post('/update', 'Auth\AsistentesController@update')->name('auth.asistentes.update');
    });
    Route::group(['prefix' => 'asistencia'], function () {
        Route::get('', 'Auth\AsistenciaController@index')->name('auth.asistencia');
        Route::get('listado', 'Auth\AsistenciaController@verlistado')->name('auth.asistencia.listado');
        Route::post('/asistentesPorCelula', 'Auth\AsistenciaController@asistentesPorCelula')->name('auth.asistentes.asistentesPorCelula');
        Route::get('/list_all', 'Auth\AsistenciaController@list_all')->name('auth.asistencia.list_all');
        Route::post('/delete', 'Auth\AsistenciaController@delete')->name('auth.asistencia.delete');
        Route::post('/store', 'Auth\AsistenciaController@store')->name('auth.asistencia.store');  
    });

    Route::group(['prefix' => 'calendario'], function () {
        Route::get('', 'Auth\CalendarioController@index')->name('auth.calendario');
        //listar en el calendario
        Route::get('list_all', 'Auth\CalendarioController@list_all')->name('auth.calendario.list_all');
        // routes/web.php
        Route::post('/store', 'Auth\CalendarioController@store')->name('auth.calendario.store');
        // routes/web.php
        Route::post('/delete', 'Auth\CalendarioController@delete')->name('auth.calendario.delete');
        /* VISTA */
        Route::get('listado', 'Auth\CalendarioController@verlistado')->name('auth.calendario.listado');
        /* LISTAR EN TABLA */
        Route::get('listarCalendario', 'Auth\CalendarioController@listarCalendario')->name('auth.calendario.listarCalendario');
        /* abrir modal con datos */
        Route::get('/partialView/{id}', 'Auth\CalendarioController@partialView')->name('auth.calendario.create');
        Route::post('/update', 'Auth\CalendarioController@update')->name('auth.calendario.update');
        Route::post('/delete', 'Auth\CalendarioController@delete')->name('auth.calendario.delete');
    });

    Route::group(['prefix' => 'seguimiento'], function () {
        Route::get('', 'Auth\SeguimientoController@index')->name('auth.seguimiento');
        Route::post('/store', 'Auth\SeguimientoController@store')->name('auth.seguimiento.store');  
    });

    Route::group(['prefix' => 'aniversario'], function () {
        Route::get('', 'Auth\AniversarioController@index')->name('auth.aniversario');
        Route::get('/list_all', 'Auth\AniversarioController@list_all')->name('auth.aniversario.list_all');  
        Route::get('/partialView/{id}', 'Auth\AniversarioController@partialView')->name('auth.aniversario.create');
    });

    Route::group(['prefix' => 'opinion'], function () {
        Route::get('', 'Auth\OpinionController@index')->name('auth.opinion');
        Route::get('/list_all', 'Auth\OpinionController@list_all')->name('auth.opinion.list_all');  
    });

});


// Ruta para almacenar un nuevo asistente para el aniversario JAC
Route::get('/aniversario', 'App\AniversarioController@index')->name('app.aniversario.index');
Route::post('/aniversario/store', 'App\AniversarioController@store')->name('aniversario.store');
//Página principal registrar opiniones
Route::post('/home/store', 'App\HomeController@store')->name('home.store');


Route::group(['prefix' => 'auth'], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout');

    Route::get('/changePassword/partialView', 'Auth\LoginController@partialView_change_password')->name('auth.login.partialView_change_password');
    Route::post('/changePassword', 'Auth\LoginController@change_password')->name('auth.login.change_password');

    /*Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');*/
});

Route::get('publicar_oferta', 'Auth\LoginController@view_publicar_oferta');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');