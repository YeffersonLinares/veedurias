<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParametrizarMenusController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\CentralizadoController;
use App\Http\Controllers\TipoDocumento2Controller;
use App\Http\Controllers\DepartamentoCentralizadoController;
use App\Http\Middleware\ChangeDb;
use App\Http\Middleware\CheckSesion;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\ValidateSesion;

// -----------INICIO IMPORTACION CONTROLADORES VEEDURIAS---------------------------------------------------------------------

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoIdentificacionController;
use App\Http\Controllers\VeeduriaController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\SubSerieController;
use App\Http\Controllers\TipoVeeduriaController;
use App\Models\TipoVeeduria;
use App\Models\Veeduria;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

// -----------FIN IMPORTACION CONTROLADORES VEEDURIAS---------------------------------------------------------------------

Route::get('/', [LoginController::class, 'logout'])->name('showlogin')->middleware('CheckSesion');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/token/{error}', [LoginController::class, 'showLoginFormRedirect']);
Route::get('autoLoginRedirect/{conexion}', [CentralizadoController::class, 'loginRedirect'])->name('autoLoginRedirect');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('autologin/{userId}/{conexion}/{token}', [CentralizadoController::class, 'change']);
});

Route::middleware('auth')->group(function () {
    Route::get('centralizadoRedirect', [CentralizadoController::class, 'getViewCentralizado'])->middleware('validateSesion');
    Route::get('centralizado/{conexion}', [CentralizadoController::class, 'change'])->name('changeDb');
    Route::get('centralizado', [CentralizadoController::class, 'index'])->name('centralizado')->middleware('validateSesion');
    Route::get('redirectCentralizado', [CentralizadoController::class, 'redirectCentralizado'])->name('redirectCentralizado');

    Route::group(["middleware" => ["CheckDepto", "ChangeDb", "validateSesion"]], function () {

        Route::get('/main', [MainController::class, 'index'])->name('main');
        Route::get('/rol', [RolController::class, 'index']);
        Route::post('/rol/create', [RolController::class, 'store']);
        Route::put('/rol/update', [RolController::class, 'update']);
        Route::put('/rol/updatePermisos', [RolController::class, 'updatePermisos']);
        Route::put('/rol/inactivar', [RolController::class, 'inactivar']);
        Route::put('/rol/activar', [RolController::class, 'activar']);
        Route::get('/rol/getrol', [RolController::class, 'getRoles']);
        Route::get('/rol/obtenerRolPermisos', [RolController::class, 'obtenerRolPermisos']);
        Route::get('/permission', [PermisosController::class, 'index']);
        Route::post('/permission/create', [PermisosController::class, 'store']);
        Route::put('/permission/update', [PermisosController::class, 'update']);
        Route::put('/permission/cambiarEstado', [PermisosController::class, 'cambiarEstado']);
        Route::get('/permission/obtenerPermisos', [PermisosController::class, 'obtenerPermisos']);
        Route::get('/tipoDoc/gettipodoc', [UserController::class, 'getTipoDoc']);

        Route::get('/usuarios', [UserController::class, 'index']);
        Route::post('/usuarios/create', [UserController::class, 'store']);
        Route::put('/usuarios/update', [UserController::class, 'update']);
        Route::put('/usuarios/inactivar', [UserController::class, 'inactivar']);
        Route::put('/usuarios/activar', [UserController::class, 'activar']);
        Route::get('/usuarios/usuarioActivo', [UserController::class, 'getUsuarioActivo']);
        Route::get('/usuarios/cambiarEstadoNoti', [UserController::class, 'cambiarEstadoNoti']);
        Route::put('/usuarios/cambiarcontraseña', [UserController::class, 'cambiarContraseña']);
        Route::get('/usuarios/getDeptoUser/{id}', [UserController::class, 'getDeptoUser']);
        Route::get('/usuarios/getUserCentralizado', [UserController::class, 'getUserCentralizado']);

        Route::get('/menus', [ParametrizarMenusController::class, 'index']);
        Route::post('/menus/create', [ParametrizarMenusController::class, 'store']);
        Route::put('/menus/update', [ParametrizarMenusController::class, 'update']);
        Route::put('/menus/cambiarEstado', [ParametrizarMenusController::class, 'cambiarEstado']);
        Route::get('/menus/consultarMenuPadre/{id}', [ParametrizarMenusController::class, 'consultarMenuPadre']);
        Route::get('/menus/consultarPermisosPadre',  [ParametrizarMenusController::class, 'consultarPermisosPadre']);
        Route::get('/menus/getMenus', [ParametrizarMenusController::class, 'getMenus']);
        Route::get('/menus/verificaUltimoHijo',  [ParametrizarMenusController::class, 'verificaUltimoHijo']);
        Route::get('/menus/getRutaRelativa', [ParametrizarMenusController::class, 'getRutaRelativa']);
        Route::get('/menus/getRutasVue', [ParametrizarMenusController::class, 'getRutasVue']);
        Route::get('/menus/getRutasVueMenu', [ParametrizarMenusController::class, 'getRutasVueMenu']);

        Route::put('/permisos/asignarPermisos',  [PermisoController::class, 'asignarPermisos']);

        Route::get('/departamentos/selectDepartamento', [DepartamentoController::class, 'selectDepartamento']);
        Route::get('/ciudades/selectCiudad/{id}', [CiudadController::class, 'selectCiudad']);
        Route::get('/departamentosCentralizado/getDepartamentos', [DepartamentoCentralizadoController::class, 'getDepartamentos']);

        Route::get('/ciudad', [CiudadController::class, 'index']);
        Route::post('/ciudad/store', [CiudadController::class, 'store']);
        Route::put('/ciudad/update', [CiudadController::class, 'update']);
        Route::put('/ciudad/inactivar', [CiudadController::class, 'inactivar']);
        Route::put('/ciudad/activar', [CiudadController::class, 'activar']);

        Route::get('/tipo_veeduria', [TipoVeeduriaController::class, 'index']);
        Route::post('/tipo_veeduria/store', [TipoVeeduriaController::class, 'store']);
        Route::put('/tipo_veeduria/update', [TipoVeeduriaController::class, 'update']);
        Route::put('/tipo_veeduria/inactivar', [TipoVeeduriaController::class, 'inactivar']);
        Route::put('/tipo_veeduria/activar', [TipoVeeduriaController::class, 'activar']);

        Route::get('/departamento', [DepartamentoController::class, 'index']);
        Route::post('/departamento/store', [DepartamentoController::class, 'store']);
        Route::put('/departamento/update', [DepartamentoController::class, 'update']);
        Route::put('/departamento/inactivar', [DepartamentoController::class, 'inactivar']);
        Route::put('/departamento/activar', [DepartamentoController::class, 'activar']);
        Route::get('/departamento/selectDepartamento', [DepartamentoController::class, 'seleccioneDepartamento']);

        Route::get('/tipoDocumento', [TipoDocumento2Controller::class, 'index']);
        Route::post('/tipoDocumento/create', [TipoDocumento2Controller::class, 'store']);
        Route::put('/tipoDocumento/update', [TipoDocumento2Controller::class, 'update']);
        Route::put('/tipoDocumento/inactivar', [TipoDocumento2Controller::class, 'inactivar']);
        Route::put('/tipoDocumento/activar', [TipoDocumento2Controller::class, 'activar']);
    });
});

//-------------------INICIO RUTAS VEEDURIAS-----------------------------------------


// Veedurias
Route::get('/nueva_veeduria', [VeeduriaController::class, 'nuevaVeeduria']); // 100%
Route::post('/nueva_veeduria_data', [VeeduriaController::class, 'nuevaVeeduriaData']); //100%
Route::get('/informe_veeduria', [VeeduriaController::class, 'informeVeeduria']); // 100%
Route::post('/informe_veeduria/data', [VeeduriaController::class, 'informeVeeduriaData']); //100%
Route::get('/lista_veeduria', [VeeduriaController::class, 'listaVeeduria']); //100%
// Route::get('/detalles_veeduria', [VeeduriaController::class, 'listaVeeduria']); // 100%
Route::get('/detalles_veeduria/{id}', [VeeduriaController::class, 'detalles_veeduria']); // 100%
Route::get('/lista_veeduria_data', [VeeduriaController::class, 'listaVeeduriaData']); //100%
Route::get('/viewEditVeeduria', [VeeduriaController::class, 'viewEditVeeduria']); //100%
Route::get('/editar_veeduria/{id}', [VeeduriaController::class, 'editarVeeduria']); // 100%
Route::post('/update_veeduria', [VeeduriaController::class, 'update_veeduria']); // 100%
Route::post('/insertar_veeduria', [VeeduriaController::class, 'insertarVeeduria']); //100%
Route::post('/eliminar_veeduria/{id}', [VeeduriaController::class, 'eliminarVeeduria']); //100%
Route::post('/edit-sesion-document', [VeeduriaController::class, 'editDocument']); //No se hace aún
Route::post('/editar_veeduria', [VeeduriaController::class, 'editarVeeduriaData']); //100%
Route::post('/munxdep/{id}', [VeeduriaController::class, 'munxdep']); //99%
Route::post('/view-documents', [VeeduriaController::class, 'viewDocuments']); // No se hace aún
Route::post('/documentoxveeduria/{id}', [VeeduriaController::class, 'documentoxveeduria']);
Route::get('/edit_veeduria/{id}', [VeeduriaController::class, 'edit']);

// Reportes
Route::get('/excel-veeduria', [ReportController::class, 'excelVeeduria']); // No se hace aún
Route::post('/excel-veeduria', [ReportController::class, 'excelVeeduria']); // No se hace aún

Route::get('/descargar_excel', [VeeduriaController::class, 'descargarExcel']); // No se hace aún
Route::get('/descargar_pdf', [VeeduriaController::class, 'descargarPDF']); // No se hace aún
Route::post('/filtrar_veeduria', [VeeduriaController::class, 'filtrar_veeduria'])->name('filtrar_veeduria'); //100%
Route::post('/filtrar_lista_veeduria', [VeeduriaController::class, 'filtrar_lista_veeduria'])->name('filtrar_lista_veeduria'); //100%


Route::get('/download', function (Request $r) {
    $veeduria = Veeduria::where('veeduria.id', $r->id)
        ->select('veeduria.*', 'ciudades.nombre AS city', 'departamentos.nombre AS departamento', 'tipo_veeduria.nombre as tipo_nombre')
        ->leftjoin("ciudades", "ciudades.id", "veeduria.ciu_id")
        ->leftjoin("departamentos", "departamentos.id", "veeduria.dep_id")
        ->join('tipo_veeduria', 'tipo_veeduria.id', 'veeduria.tipo_id')
        ->first();
    $radicado = $r->radicado;
    $proyecto = $r->proyecto;
    $reviso = $r->reviso;
    $pdf = \PDF::loadView('report.veeduria_PDF', [
        'radicado' => $radicado,
        'proyecto' => $proyecto,
        'reviso' => $reviso,
        'data' => $veeduria,
    ]);
    // return $pdf->stream('reporte_veeduría.pdf');
    return $pdf->download('reporte_veeduría.pdf');
});


//--------------------------------------------------------------------------------------
// Rutas para tipos de documento
//--------------------------------------------------------------------------------------

Route::get('/tipos-de-archivo', [TipoDocumentoController::class, 'index']);
Route::get('/index_tipo_d', [TipoDocumentoController::class, 'index_tipo_d']);
Route::post('modal_eliminar_tipoDocumento', [TipoDocumentoController::class, 'modal_eliminar_tipoDocumento'])->name('modal_eliminar_tipoDocumento');
Route::post('eliminar_tipoDocumento/{id}', [TipoDocumentoController::class, 'destroy'])->name('tipoDocumento.destroy');
Route::post('/modal_creartipoDocumento', [TipoDocumentoController::class, 'modal_crear_municipio'])->name('modal_crear_tipoDocumento');
Route::post('/crear_tipoDocumento', [TipoDocumentoController::class, 'store'])->name('tipoDocumento.store');
Route::post('/editar_tipoDocumento', [TipoDocumentoController::class, 'edit'])->name('tipoDocumento.edit');
Route::post('/update_tipoDocumento', [TipoDocumentoController::class, 'update'])->name('tipoDocumento.update');
Route::post('/buscar-tipoDocumento/{nombre}', [TipoDocumentoController::class, 'buscar_tipoDocumento'])->name('buscar_tipoDocumento');


//--------------------------------------------------------------------------------------
// Rutas para tipos de identifiación
//--------------------------------------------------------------------------------------

// Route::get('/tipos-de-identificacion', [TipoIdentificacionController::class, 'index']);
// Route::get('/index_tipo_i', [TipoIdentificacionController::class, 'index_tipo_i']);
// Route::post('modal_eliminar_tipoIdentificacion', [TipoIdentificacionController::class, 'modal_eliminar_tipoIdentificacion'])->name('modal_eliminar_tipoIdentificacion');
// Route::post('eliminar_tipoIdentificacion/{id}', [TipoIdentificacionController::class, 'destroy'])->name('tipoIdentificacion.destroy');
// Route::post('/modal_creartipoIdentificacion', [TipoIdentificacionController::class, 'modal_crear_municipio'])->name('modal_crear_tipoIdentificacion');
// Route::post('/crear_tipoIdentificacion', [TipoIdentificacionController::class, 'store'])->name('tipoIdentificacion.store');
// Route::post('/editar_tipoIdentificacion', [TipoIdentificacionController::class, 'edit'])->name('tipoIdentificacion.edit');
// Route::post('/update_tipoIdentificacion', [TipoIdentificacionController::class, 'update'])->name('tipoIdentificacion.update');
// Route::post('buscar-tipoIdentificacion/{nombre}', [TipoIdentificacionController::class, 'buscar_tipoIdentificacion'])->name('buscar_tipoIdentificacion');


    //Route::get('/tipoIdentificacion',[TipoDocumento2Controller::class,'index']);
    //Route::post('/tipoIdentificacion/create', [TipoDocumento2Controller::class,'store']);
    //Route::put('/tipoIdentificacion/update', [TipoDocumento2Controller::class,'update']);
    //Route::put('/tipoIdentificacion/inactivar', [TipoDocumento2Controller::class,'inactivar']);
    //Route::put('/tipoIdentificacion/activar', [TipoDocumento2Controller::class,'activar']);
    //Route::get('/tipoIdentificacion/selectTipoIdentificacion', [TipoDocumento2Controller::class,'seleccioneTipoIdentificacion']);

    Route::get('/tipoIdentificacion',[TipoDocumentoController::class,'index']);
    Route::post('/tipoIdentificacion/create', [TipoDocumentoController::class,'store']);
    Route::put('/tipoIdentificacion/update', [TipoDocumentoController::class,'update']);
    Route::put('/tipoIdentificacion/inactivar', [TipoDocumentoController::class,'inactivar']);
    Route::put('/tipoIdentificacion/activar', [TipoDocumentoController::class,'activar']);
    Route::get('/tipoIdentificacion/selectTipoIdentificacion', [TipoDocumentoController::class,'seleccioneTipoIdentificacion']);

//-------------------FIN RUTAS VEEDURIAS-----------------------------------------
