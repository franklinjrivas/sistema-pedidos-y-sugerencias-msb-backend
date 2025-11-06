<?php
use App\Http\Controllers\AtencionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BasicAuthentication;
use App\Http\Middleware\JWTAuthentication;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\WsController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware(BasicAuthentication::class);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(JWTAuthentication::class);
    Route::post('/check-intranet-url', [AuthController::class, 'check_intranet_url'])->middleware(JWTAuthentication::class);
    Route::post('/validate-jwt', [AuthController::class, 'validate_jwt'])->middleware(JWTAuthentication::class);
});

Route::middleware(JWTAuthentication::class)->prefix('home')->group(function () {
    Route::post('/roles', [HomeController::class, 'roles']);
    Route::post('/menu', [HomeController::class, 'menu']);
    Route::post('/change-rol', [HomeController::class, 'change_rol']);
});
Route::middleware(JWTAuthentication::class)->prefix('consulta')->group(function () {
    Route::post('/list-tipos', [ConsultaController::class, 'listtipos']);
    Route::post('/list-recepcion', [ConsultaController::class, 'listrecepcion']);
    Route::post('/listar-personas', [PersonaController::class, 'listarpersona']);
    Route::post('/listar-doc-identidad', [PersonaController::class, 'listardocidentidad']);
    Route::post('/listar-departamentos', [PersonaController::class, 'listardepartamentos']);
    Route::post('/listar-provincias', [PersonaController::class, 'listarprovincias']);
    Route::post('/listar-distritos', [PersonaController::class, 'listardistritos']);
    Route::post('/listar-urbanizaciones', [PersonaController::class, 'listarurbanizaciones']);
    Route::post('/listar-vias', [PersonaController::class, 'listarvias']);
    Route::post('/detalle-mesaayuda', [PersonaController::class, 'detallemesaayuda']);
    Route::post('/listar-interiores', [PersonaController::class, 'listarinteriores']);
    Route::post('/guardar-contribuyente', [PersonaController::class, 'guardarcontribuyente']);
    Route::post('/listar-motivos', [PersonaController::class, 'listamotivos']);
    Route::post('/grabar-expediente', [ExpedienteController::class, 'grabar_expediente']);
    Route::post('/botones-expediente', [ExpedienteController::class, 'botones_expediente']);
});
Route::middleware(JWTAuthentication::class)->prefix('atencion')->group(function () {
    Route::post('/lista-expedientes-pendiente', [AtencionesController::class, 'listaexpedientespendientes']);
    Route::post('/detalle-expediente-pendiente', [AtencionesController::class, 'detalleexpedientependiente']);
    Route::post('/recepcionar-expediente', [AtencionesController::class, 'recepcionarexpediente']);
    Route::post('/lista-expedientes-recepcionados', [AtencionesController::class, 'listaexpedientesrecepcionados']);
    Route::post('/listar-areas', [AtencionesController::class, 'listarareas']);
    Route::post('/extornar-expediente', [AtencionesController::class, 'extornarexpediente']);
    Route::post('/cargar-detalle-documento-recepcionados', [AtencionesController::class, 'cargardetalledocumentorecepcionados']);
    Route::post('/grabar-documento-recepcionados', [AtencionesController::class, 'grabardocumentorecepcionados']);
    Route::post('/mostrar-detalle-notificacion', [AtencionesController::class, 'mostrardetallenotificacion']);
    Route::post('/lista-notificacion', [AtencionesController::class, 'listanotificacion']);
    Route::post('/eliminar-notificacion', [AtencionesController::class, 'eliminarnotificacion']);
    Route::post('/cerrar-expediente', [AtencionesController::class, 'cerrar_expediente']);

    Route::post('/listar-derivacion', [AtencionesController::class, 'listarderivacion']);
    Route::post('/derivar-expediente', [AtencionesController::class, 'derivar_expediente']);
    Route::post('/lista-expedientes-derivados', [AtencionesController::class, 'lista_expedientes_derivados']);
    Route::post('/buscar-expedientes', [AtencionesController::class, 'buscar_expedientes']);
    Route::post('/lista-tipos-busqueda', [AtencionesController::class, 'lista_tipos_busqueda']);
    Route::post('/lista-filtros-busqueda', [AtencionesController::class, 'lista_filtros_busqueda']);
    Route::post('/lista-motivos-reportes', [AtencionesController::class, 'lista_motivos_reportes']);
    Route::post('/buscar-id', [AtencionesController::class, 'buscar_id']);
});

Route::middleware(JWTAuthentication::class)->prefix('reportes')->group(function () {
    Route::post('/lista-registro-por-fechas', [ReportesController::class, 'lista_registro_por_fechas']);
    Route::post('/lista-registro-por-area', [ReportesController::class, 'lista_registro_por_area']);
    Route::post('/lista-registro-por-area-pendientes', [ReportesController::class, 'lista_registro_por_area_pendientes']);
    Route::post('/lista-registro-por-area-pendientes-resumen', [ReportesController::class, 'lista_registro_por_area_pendientes_resumen']);
    Route::post('/lista-resumen-alertas', [ReportesController::class, 'lista_resumen_alertas']);
    Route::post('/buscar-contribuyente', [ReportesController::class, 'buscar_contribuyente']);
    Route::post('/buscar-documentos-recepcionados', [ReportesController::class, 'buscar_documentos_recepcionados']);
    Route::post('/buscar-parte-diario', [ReportesController::class, 'buscar_parte_diario']);
    Route::post('/consultar-expediente', [ReportesController::class, 'consultar_expediente']);
    Route::post('/consultar-data-email', [ReportesController::class, 'consultar_data_email']);
    Route::post('/consultar-informacion-documento', [ReportesController::class, 'consultar_informacion_documento']);
});


Route::middleware(JWTAuthentication::class)->prefix('mantenimiento')->group(function () {
    Route::post('/listar-tipo-mantenimiento', [MantenimientoController::class, 'listar_tipo_mantenimiento']);
    Route::post('/listar-data-mantenimiento', [MantenimientoController::class, 'listar_data_mantenimiento']);
    Route::post('/eliminar-mantenimiento', [MantenimientoController::class, 'eliminar_mantenimiento']);
    Route::post('/guardar-mantenimiento', [MantenimientoController::class, 'guardar_mantenimiento']);
    Route::post('/listar-tipo-detalla-mantenimiento', [MantenimientoController::class, 'listar_tipo_detalla_mantenimiento']);
    Route::post('/listar-areas-insertar-motivos', [MantenimientoController::class, 'listar_areas_insertar_motivos']);
});

// GENERADOR DE PDF
Route::prefix('pdf')->group(function () {
    // Route::get('/{tipo_pdf}/{identificador}', [PDFController::class, 'buildPDF']);
    Route::get('/{tipo}/{anio}/{codigo}/{tipo_pdf}', [PDFController::class, 'buildPDF']);
    // Route::get('/{tipo_pdf}/{identificador}', [PDFController::class, 'buildPDF']);
    // Route::get('/{tipo_pdf}/{identificador}/{id}', [PDFController::class, 'buildPDF']);
    // Route::get('/{tipo_pdf}/{identificador}/{monto}/{porcent}/{cuota}', [PDFController::class, 'buildPDF']);
});

Route::prefix('mail')->group(function () {
    Route::post('/send', [SendEmailController::class, 'send_mail']);

});
Route::prefix('ws')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('bi')->group(function () {
            Route::match(['get', 'post'], '/excel-registros-reportes', [WsController::class, 'v1_bi_excel_registros_reportes']);
        });
    });
});

