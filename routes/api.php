<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Contenido_por_LeccionController;
use App\Http\Controllers\Api\UbicacionController;
use App\Http\Controllers\Api\EmprendedorApiController;
use App\Http\Controllers\Api\AliadoApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AsesoriasController;
use App\Http\Controllers\Api\EmpresaApiController;
use App\Http\Controllers\Api\Apoyo_por_EmpresaController;
use App\Http\Controllers\Api\ActividadController;
use App\Http\Controllers\Api\LeccionController;
use App\Http\Controllers\Api\NivelesController;
use App\Http\Controllers\Api\AsesorApiController;
use App\Http\Controllers\Api\DashboardsController;
use App\Http\Controllers\Api\FormResponsesController;
use App\Http\Controllers\Api\RutaApiController;
use App\Http\Controllers\Api\SuperAdminController;
use App\Http\Controllers\Api\OrientadorApiController;
use App\Http\Controllers\Api\PuntajeController;
use App\Http\Controllers\Api\ReportesController;
use App\Http\Controllers\Api\RespuestasApiController;





Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register_em', [AuthController::class, 'register'])->name('register');
    Route::post('/validate_email_em', [AuthController::class, 'validate_email'])->name('validate_email');
    Route::post('/send-reset-password', [AuthController::class, "enviarRecuperarContrasena"]);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
});


//Empresa
Route::group([
    'prefix' => 'empresa',
    'middleware' => 'auth:api'
], function () {
    Route::post('/createEmpresa', [EmpresaApiController::class, 'store']);
    Route::post('/createApoyo', [Apoyo_por_EmpresaController::class, 'crearApoyos']);
    Route::put('/updateEmpresa/{documento}', [EmpresaApiController::class, 'update']);
    Route::get('/getEmpresa/{id_emprendedor}/{documento}', [EmpresaApiController::class, 'getOnlyEmpresa']);
    Route::get('/getApoyo/{id_empresa}', [Apoyo_por_EmpresaController::class, 'getApoyosxEmpresa']);
    //Route::get('/getApoyoxdocumento/{documento}', [Apoyo_por_EmpresaController::class, 'getApoyoxDocumento']);
    Route::put('/updateApoyo/{documento}', [Apoyo_por_EmpresaController::class, 'editarApoyo']);
    Route::get('/getAllEmpresa', [EmpresaApiController::class,'index']);
    Route::get('/getEmpresaByEmprendedor', [EmpresaApiController::class, 'obtenerEmpresasPorEmprendedor']);
});


//Emprendedor
Route::group([
    'prefix' => 'emprendedor',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('/emprendedor', EmprendedorApiController::class);
    Route::post('/editarEmprededor/{documento}', [EmprendedorApiController::class, 'updateEmprendedor']);
    Route::get('/userProfileEmprendedor/{documento}', [AuthController::class, 'userProfileEmprendedor']);
});
Route::get('/tipo_documento', [EmprendedorApiController::class, 'tipoDocumento']);

//Orientador
Route::group([
    'prefix' => 'orientador',
    'middleware' => 'auth:api'
], function () {
    Route::post('/crearOrientador', [OrientadorApiController::class, 'createOrientador']);
    Route::post('/asesorias/{idAsesoria}/asignar-aliado', [OrientadorApiController::class, 'asignarAsesoriaAliado']);
    Route::get('/listaAliado', [OrientadorApiController::class, 'listarAliados']);
    Route::get('/listaOrientador/{status}', [OrientadorApiController::class, 'mostrarOrientadores']);
    Route::post('/editarOrientador/{id}', [OrientadorApiController::class, 'editarOrientador']);
    Route::get('/userProfileOrientador/{id}', [OrientadorApiController::class, 'userProfileOrientador']);
});


//Super Admin
Route::group([
    'prefix' => 'superadmin',
    'middleware' => 'auth:api',
], function () {
    Route::post('/personalizacion/{id}', [SuperAdminController::class, 'personalizacionSis']);
    Route::post('/restaurarPersonalizacion/{id}', [SuperAdminController::class, 'restore']);
    Route::post('/crearSuperAdmin', [SuperAdminController::class, 'crearSuperAdmin']);
    Route::delete('/desactivar', [SuperAdminController::class, 'destroy']);
    Route::post('/editarAdmin/{id}', [SuperAdminController::class, 'editarSuperAdmin']);
    Route::get('/userProfileAdmin/{id}', [SuperAdminController::class, 'userProfileAdmin']);
    //Route::get('/perfilAdmin/{id}', [SuperAdminController::class, 'userProfileAdmin']);
    Route::get('/mostrarSuperAdmins', [SuperAdminController::class, 'mostrarSuperAdmins']);
    Route::get('/asesor-aliado', [SuperAdminController::class, 'asesorConAliado']);
    Route::get('/listAliado', [SuperAdminController::class, 'listarAliados']);
});


//UbicacionController
Route::get('/deps/all', [UbicacionController::class, 'listar_dep'])->name('listar_dep');
Route::get('/mun', [UbicacionController::class, 'listar_munxdep'])->name('listar_munxdep');

//AliadoController
Route::group([
    'prefix' => 'aliado',
    'middleware' => 'auth:api',
], function () {
    //Route::get('/verinfoaliado', [AliadoApiController::class, 'mostrarAliado'])->name('mostrarAliado');
    //Route::match(['post', 'put'],'/editaraliado/{id}', [AliadoApiController::class, 'editarAliado']);
    Route::post('/editaraliado/{id}', [AliadoApiController::class, 'editarAliado']);
    Route::get('/banner/{id_aliado}', [AliadoApiController::class, 'traerBannersxaliado'])->name('traerBannersxaliado');
    Route::get('/bannerxid/{id}', [AliadoApiController::class, 'traerBannersxID'])->name('traerBannersxID');
    Route::get('/traeraliadoxid/{id}', [AliadoApiController::class, 'traerAliadoxId'])->name('traerAliadoxId');
    Route::get('/mostrarAsesorAliado/{id}', [AliadoApiController::class, 'mostrarAsesorAliado'])->name('MostrarAsesorAliado'); //////////
    Route::delete('/{id}', [AliadoApiController::class, 'destroy'])->name('desactivarAliado');
    Route::post('/create_aliado', [AliadoApiController::class, 'crearAliado'])->name('crearaliado');
    Route::put('/editarAsesorAliado/{id}', [AliadoApiController::class, 'editarAsesorXaliado'])->name('EditarAsesorAliado');
    Route::get('/emprendedores&empresa', [AliadoApiController::class, 'verEmprendedoresxEmpresa']);
    Route::get('/generoAliado', [AliadoApiController::class, 'generos']);
    Route::post('/crearbannerr', [AliadoApiController::class, 'crearBanner']);
    Route::post('/editarbanner/{id}', [AliadoApiController::class, 'editarBanner']);
    Route::delete('/eliminarbanner/{id}', [AliadoApiController::class, 'eliminarBanner']);
    Route::get('/mostrarAliados', [AliadoApiController::class, 'mostrarAliados']);

});

//Dashboard
Route::group(
    [
        'prefix' => 'dashboard',
        'middleware' => 'auth:api'
    ],
    function () {
        //Route::get('/emprendedor_departamento', [DashboardsController::class, 'emprendedorXdepartamento']);
        //Route::get('/averageAsesorias2024', [DashboardsController::class, 'averageAsesorias2024']);
        Route::get('/contar-usuarios', [DashboardsController::class, 'getDashboardData']);
        //Route::get('/conteoAsesorias', [DashboardsController::class, 'asesoriasAsignadasSinAsignar']);
        //Route::get('/listRegistrosAnioMes', [DashboardsController::class, 'conteoRegistrosAnioYMes']);
        //Route::get('/promEmpresas_Mes', [DashboardsController::class, 'promEmpresasXmes']);
        //Route::get('/generoAliado', [DashboardsController::class, 'generos']);
        Route::get('/dashboardAliado/{idAliado}', [DashboardsController::class, 'dashboardAliado']);
        Route::get('/asesoriasTotalesAliado', [DashboardsController::class, 'asesoriasTotalesAliado']);
        //Route::get('/asesorias_mes/{id}', [DashboardsController::class, 'asesoriasXmes']);
        Route::get('/graficaFormulario/{id_empresa}/{tipo}', [DashboardsController::class, 'getRadarChartData']);
    }
);

//Reportes

route::get('/exportar-formExcel/{idEmprendedor}/{documentoEmpresa?}/{tipo_reporte}', [ReportesController::class, 'procesarRespuestas']);
Route::post('/exportar_reporte', [ReportesController::class, 'exportarReporte']);
Route::get('/obtener_datos_reporte', [ReportesController::class, 'obtenerDatosReporte']);
Route::get('/obtener_datos_aliados', [ReportesController::class, 'mostrarReportesAliados']);
Route::post('/exportar_reporte_aliado', [ReportesController::class, 'exportarReportesAliados']);
Route::get('/obtener_datos_formEmprendedor', [ReportesController::class, 'mostrarReporteFormEmprendedor']);

//FanPage
Route::get('/aliado/{status}', [AliadoApiController::class, 'traerAliadosActivos'])->name('Traeraliadosactivos');
Route::get('/traerPersonalizacion/{id}', [SuperAdminController::class, 'obtenerPersonalizacion']);
Route::get('/banner/{status}', [AliadoApiController::class, 'traerBanners']);
Route::get('/traerAliadosiau/{id}', [AliadoApiController::class, 'getAllAliados'])->name('traerAliadosiau');

//descargas y buscar ruta
Route::get('/descargar-archivo/{contenidoId}', [RutaApiController::class, 'descargarArchivoContenido']);
Route::get('/ultimaruta/{rutaId}', [RutaApiController::class, 'getRutaInfo']);
//Puntaje
Route::group([], function () {
    Route::post('/puntajes/{documento}', [PuntajeController::class, 'store']);
    Route::get('/puntajeXemprendedor/{id}', [PuntajeController::class, 'getPuntajeXEmpresa']);
});


//Rutas
Route::group([
    'prefix' => 'ruta',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('/ruta', RutaApiController::class);
    Route::get('/mostrarRutaContenido/{id}', [RutaApiController::class, 'mostrarRutaConContenido'])->name('mostrarRutaContenido');
    Route::get('/rutasActivas', [RutaApiController::class, 'rutasActivas']);
    Route::get('/rutas', [RutaApiController::class, 'rutas']);
    Route::get('/rutasmejorado', [RutaApiController::class, 'rutasmejorado']);
    Route::get('/rutaXid/{id}', [RutaApiController::class, 'rutaxId']);
    Route::get('/actnivleccontXruta/{id}', [RutaApiController::class,'actnivleccontXruta']);
    Route::get('/actnividadxAliado/{id}/{id_aliado}', [RutaApiController::class,'actnividadxAliado']);
    Route::get('/actnividadxNivelAsesor/{id}/{id_asesor}', [RutaApiController::class,'actnividadxNivelAsesor']);
    Route::get('/actividadcompleta/{id}', [RutaApiController::class,'actividadCompletaxruta']);
    Route::get('/idRespuestasHeidy/{id_emprendedor}', [RutaApiController::class, 'idRespuestas']);

});


//Actividad
Route::group([
    'prefix' => 'actividad',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('/actividad', ActividadController::class);
    Route::post('/crearActividad', [ActividadController::class, 'store']);
    Route::post('/editar_actividad/{id}', [ActividadController::class, 'editarActividad']);
    Route::get('/tipo_dato', [ActividadController::class, 'tipoDato']);
    Route::get('/verActividadAliado/{id}', [ActividadController::class, 'VerActividadAliado']);
    Route::put('/activar_desactivar_actividad/{id}', [ActividadController::class, 'Activar_Desactivar_Actividad']);
    Route::get('/ActiNivelLeccionContenido/{id}', [ActividadController::class, 'ActiNivelLeccionContenido']);
    Route::get('/ActividadAsesor/{id}', [ActividadController::class, 'actividadAsesor']);

});

//Nivel
Route::group([
    'prefix' => 'nivel',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('/nivel', NivelesController::class)->middleware('auth:api');
    Route::post('/crearNivel', [NivelesController::class, 'store']);
    Route::put('/editar_nivel/{id}', [NivelesController::class, 'editarNivel']);
    Route::get('/listar_Nivel', [NivelesController::class, 'listarNiveles']);
    Route::get('/nivelXactividad/{id}', [NivelesController::class, 'NivelxActividad']);
    Route::get('/NivelxActividadxAsesor/{id_actividad}/{id_asesor}', [NivelesController::class, 'NivelxActividadxAsesor']);
});

//Leccion
Route::group([
    'prefix' => 'leccion',
    'middleware' => 'auth:api'
],function(){
    Route::apiResource('/leccion',LeccionController::class);
    Route::post('/crearLeccion',[LeccionController::class,'store']);
    Route::get('/leccionXnivel/{id}',[LeccionController::class,'LeccionxNivel']);
    Route::put('/editar_leccion/{id}',[LeccionController::class,'editarLeccion']);
    //Route::apiResource('/leccion',LeccionController::class)->middleware('auth:api');
});


//Contenido_por_Leccion
Route::group([
    'prefix' => 'contenido_por_leccion',
    'middleware' => 'auth:api'
],function(){
    Route::apiResource('/contenido_por_leccion',Contenido_por_LeccionController::class);
    Route::post('/crearContenidoPorLeccion',[Contenido_por_LeccionController::class,'store']);
    Route::post('/editarContenidoPorLeccion/{id}',[Contenido_por_LeccionController::class,'editarContenidoLeccion']);
    Route::get('/tipo_dato',[Contenido_por_LeccionController::class,'tipoDatoContenido']);
    Route::get('/mostrarContenidoPorLeccion/{id}',[Contenido_por_LeccionController::class,'verContenidoPorLeccion']);
});
//Route::apiResource('/contenido_por_leccion',Contenido_por_LeccionController::class)->middleware('auth:api');

//Asesor
Route::group([
    'prefix' => 'asesor',
    'middleware' => 'auth:api'
], function () {
    Route::apiResource('/asesor', AsesorApiController::class);
    Route::post('/editarAsesor/{id}', [AsesorApiController::class, 'updateAsesor']);
    Route::post('/editarAsesorxaliado/{id}', [AsesorApiController::class, 'updateAsesorxaliado']);
    Route::get('/mostrarAsesoriasAsesor/{id}/{conHorario}', [AsesorApiController::class, 'mostrarAsesoriasAsesor']);
    Route::get('/contarAsesorias/{idAsesor}', [AsesorApiController::class, 'contarAsesorias']);
    Route::get('/userProfileAsesor/{id}', [AsesorApiController::class, 'userProfileAsesor'])->name('UserProfileAsesor');
    Route::get('/listadoAsesores', [AsesorApiController::class, 'listarAsesores']);
});


//Asesorias
Route::group([
    'prefix' => 'asesorias',
    'middleware' => 'auth:api'
], function () {
    Route::post('/solicitud_asesoria', [AsesoriasController::class, 'guardarAsesoria']); //guardar asesoria - emprendedor
    Route::post('/asignar_asesoria', [AsesoriasController::class, 'asignarAsesoria'])->name('asignarasesoria'); //asignar asesoria - aliado
    Route::post('/horario_asesoria', [AsesoriasController::class, 'definirHorarioAsesoria'])->name('definirhorarioasesoria'); //asignar horario - asesor
    Route::put('/editar_asignar_asesoria', [AsesoriasController::class, 'definirHorarioAsesoria'])->name('editarasignacionasesoria'); //editar asesor - aliado
    Route::post('/mis_asesorias', [AsesoriasController::class, 'traerAsesoriasPorEmprendedor'])->name('traerAsesoriasPorEmprendedor'); // ver asesorias - emprendedor
    Route::post('/asesoriaOrientador', [AsesoriasController::class, 'traerasesoriasorientador'])->name('traerAsesoriasOrientador');; // ver asesorias - orientador
    Route::post('/{idAsesoria}/asignar-aliado', [AsesoriasController::class, 'asignarAliado']); // dar aliado a asesoria - orientador
    Route::get('/mostrarAsesorias/{id}/{asignacion}', [AsesoriasController::class, 'MostrarAsesorias'])->name('MostrarAsesorias'); //ver asesorias de aliado
    Route::get('/asesores_disponibles/{idaliado}', [AsesoriasController::class, 'listarasesoresdisponibles'])->name('listarasesoresdisponibles'); //ver asesores disponibles por aliado
    Route::post('/gestionar', [AliadoApiController::class, 'gestionarAsesoria']);
});

//Respuestas formulario
Route::group([
    'prefix' => 'respuestas',
    'middleware' => 'auth:api'
], function () {
    Route::post('/guardar-respuestas', [RespuestasApiController::class, 'guardarRespuestas']);
    Route::apiResource('/respuestas', RespuestasApiController::class);
    Route::post('/form/section/{id_empresa}/{sectionId}', [FormResponsesController::class, 'storeSection']);
    Route::get('/form/section/{sectionId}', [FormResponsesController::class, 'getSection']);
    Route::get('/getRespuestasRedis/{empresaId}', [FormResponsesController::class, 'getAllRespuestasFromRedis']);
    Route::get('/verificarEstadoForm/{id_empresa}', [RespuestasApiController::class, 'verificarEstadoFormulario']);
});

