<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AtencionesService
{

    public function listar_expedientes_pendientes(array $datos)
    {
        try {
            $area = DB::select(
                'exec piap_qj_tramite_area_usuario ?',
                [$datos['JWT_username']]
            );
            $idareauauario = $area[0]->idarea;

            $data = DB::select(
                'exec piap_qj_tramite_entrada_porrecepcionar ?',
                [$idareauauario]
            );

            return [
                'success' => true,
                'mensaje' => '',
                'data' => empty($data) ? null : $data
            ];
            return $data;
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function detalle_expediente_pendiente(array $datos)
    {
        try {
            $data = DB::select(
                'exec piap_qj_tramite_detalle ?,?,?',
                [$datos['anio'], $datos['codigo'], $datos['pase']]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listdetalles' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function recepcionar_expediente(string $datos, ?string $user)
    {
        try {
            $data = DB::statement(
                'exec piap_qj_tramite_entrada_recepciona ?,?',
                [$datos, $user]
            );
            log_info($data);
            return [
                'success' => true,
                'mensaje' => '',
                'listdetalles' => $data,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_expedientes_recepcionados(array $datos)
    {
        try {

            $area = DB::select(
                'exec piap_qj_tramite_area_usuario ?',
                [$datos['JWT_username']]
            );


            // $area = DB::select(
            //     'exec piap_qj_tramite_entrada_recepciona ?',
            //     [$datos['JWT_username']]
            // );
            $idareauauario = $area[0]->idarea;
            $data = DB::select(
                'exec piap_qj_tramite_entrada_recepcionados_2 ?,?,?,?,?',
                [$datos['areasalida'], $idareauauario,  $datos['tipobusqueda'], $datos['anio'], $datos['mes']]
            );

            $total_listado = DB::select(
                'exec piap_qj_tramite_cantidad_recepcionados ?,?,?,?,?',
                [$datos['areasalida'],  $idareauauario,  $datos['tipobusqueda'], $datos['anio'], $datos['mes']]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $data,
                'total' => $total_listado,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function lista_expedientes_derivados(array $datos)
    {
        try {
            $area = DB::select(
                'exec piap_qj_tramite_area_usuario ?',
                [$datos['JWT_username']]
            );
            $idareauauario = $area[0]->idarea;

            $tipo = $datos['tipo'] == '3' ? 6 : 5;
            $data = DB::select(
                'exec piap_qj_tramite_enviados_1 ?,?,?,?,?',
                [$idareauauario,$datos['area'],  $datos['anio'], $datos['mes'], $tipo]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $data,
                // 'total' => $total_listado,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_areas(array $datos)
    {
        try {
            $area = DB::select(
                'exec piap_qj_tramite_area_usuario ?',
                [$datos['JWT_username']]
            );
            $idareauauario = $area[0]->idarea;
            switch ($datos['tipo']) {
                case '1':
                    $data = DB::select(
                        'exec piap_qj_lista_areas_expedientes ?, ?',
                        [$idareauauario, 1]
                    );
                    break;
                case '2':
                    $data = DB::select(
                        'exec piap_qj_lista_areas_expedientes ?, ?',
                        [$idareauauario, 3]
                    );
                    break;
                case '3':
                    $data = DB::select(
                        'exec piap_qj_lista_areas_expedientes_derivados_resueltos ?, ?, ?, ?',
                        [$idareauauario, $datos['anio'], $datos['mes'],6]
                    );
                    break;
                case '4':
                    $data = DB::select(
                        'exec piap_qj_lista_areas_expedientes ?, ?',
                        [$idareauauario, 5]
                    );
                    break;
            }

            return [
                'success' => true,
                'mensaje' => '',
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function extornar_expediente(array $datos, array $user)
    {
        try {
            $usuario = $user['data']['username_magic'];
            $data = DB::select(
                'exec piap_qj_tramite_entrada_extornar ?,?,?,?',
                [$datos['anio'], $datos['codigo'], $datos['pase'], $usuario]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function buscar_id_area_p()
    {
        try {
            $id = DB::select(
                'exec piap_qj_buscar_id_particiácion_act',
                []
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $id,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function buscar_expedientes(array $datos)
    {
        try {

            $tipo = $datos['datos']['tipo'] ? $datos['datos']['tipo'] : 0;
            $ano = $datos['datos']['anio'] ? $datos['datos']['anio'] : null;
            $codigo = $datos['datos']['codigo'] ? $datos['datos']['codigo'] : null;
            $documento = $datos['datos']['documento'] ? $datos['datos']['documento'] : null;

            $formato = $datos['datos']['formato'] ?? null;
            $expediente = $codigo ? $codigo : $documento;

            if ($formato) {

                $data = DB::select(
                    'exec piap_qj_tramite_seguimiento_imprime ?,?',
                    [$ano, $expediente]
                );

                $param = [
                    'data' => $data,
                ];
                $pdf = PDF::loadView('plantillas-pdf.docreg', $param)->setPaper('a4', 'landscape');
                $content = $pdf->output();
                $base64 = base64_encode($content);
                return $base64;
            } else {

                $data1 = DB::select(
                    'exec piap_qj_documadmin_lista ?,?,?,?,?,?,?,?',
                    [null, null, null, null,$tipo, (string) $ano, $expediente,null]
                );

                $data = DB::select(
                    'exec piap_qj_tramite_seguimiento ?,?,?,?',
                    [$tipo, $ano, $codigo, $documento]
                );

            }
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $data,
                'data1' => $data1,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function lista_tipos_busqueda(array $datos)
    {
        try {
            $data = DB::select(

                'exec piap_qj_tipodocpresentado_lista ?',
                [1]
            );
            return [
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function lista_filtros_busqueda(array $datos)
    {
        try {
            $area = DB::select(
                'exec piap_trw_areas_lista ?,?',
                [0, 1]
            );
            $canales = DB::select(
                'exec piap_qj_canales_lista ',
                []
            );
            return [
                'data' => $area,
                'canal' => $canales,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function lista_motivos_reportes(array $datos)
    {
        try {
            $motivos = DB::select(
                'exec piap_qj_motivos_lista ?,?',
                [$datos['tipo'], $datos['area'], 1]
            );
            return [
                'data' => $motivos,

            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function cargar_detalle_documento(array $datos)
    {
        try {
            $DetalleTramiteEntrada = DB::select(
                'exec piap_qj_tramite_detalle ?,?,?',
                [$datos['anio'], $datos['numero'], $datos['pase']]
            );
            $OrganigDetalle = DB::select(
                'exec piap_qj_organig_lista ?',
                [1]
            );
            $codigo = $OrganigDetalle[0]->CODIGO;
            $rstAreasLista = DB::select(
                'exec piap_qj_areas_lista ?,?',
                [$codigo, 1]
            );
            $tipoDocumListado = DB::select(
                'exec piap_qj_tipodocumentos_lista ?',
                [1]
            );
            $tipoDocumResuelveListado = DB::select(
                'exec piap_qj_tipodocumentos_lista',
                []
            );
            $tipoResultadosListado = DB::select(
                'exec piap_qj_tiporesultados_lista',
                []
            );

            // $notificacionlistado = DB::select(
            //     'exec piap_qj_documadmin_lista ?,?,?,?,?,?,?,?',
            //         [$datos['area'],null,null,null,  $datos['tipo'], $datos['anio'], $datos['numero'], $datos['pase']]
            //     );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $DetalleTramiteEntrada,
                'organigDetalle' => $OrganigDetalle,
                'areasLista' => $rstAreasLista,
                'tipoDocumListado' => $tipoDocumListado,
                'tipoDocumResuelveListado' => $tipoDocumResuelveListado,
                'tipoResultadosListado' => $tipoResultadosListado,
                // 'notificalista' => $notificacionlistado,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function grabar_documento(array $datos)
    {
        try {
            $datausuario = DB::select(
                'exec piap_sp_areageneral ?',
                [$datos['datos']['area']]
            );
            $grabaresult = DB::select(
                'exec piap_qj_documadmin_actualiza ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                [$datos['datos']['id'], $datos['datos']['organig'], $datos['datos']['area'], $datos['datos']['area_docu'], $datos['datos']['tipo_docu'], (string)$datos['datos']['ano_docu'], $datos['datos']['nro_docu'], $datausuario[0]->SIGLAS, $datos['datos']['fecha_docu'], $datos['datos']['ctrb'], $datos['datos']['direccion'], $datos['datos']['folios'], $datos['datos']['plazo_dias'], $datos['datos']['tipo_plazo'], $datos['datos']['observaciones'], $datos['datos']['organig_origen'], $datos['datos']['area_origen'], $datos['datos']['persona_origen'], $datos['datos']['tipo_docu_origen'], $datos['datos']['ano_docu_origen'], $datos['datos']['nro_docu_origen'], $datos['datos']['siglas_docu_origen'], $datos['datos']['fecha_docu_origen'], $datos['datos']['resuelve'], $datos['datos']['resultado'], $datos['datos']['motivo_origen'], $datos['datos']['tipo_tramite_origen'], $datos['datos']['ano_tramite_origen'], $datos['datos']['nro_tramite_origen'], $datos['datos']['item_tramite_origen'], $datos['JWT_username']]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $grabaresult,

            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function notificacion_detalle(int $id)
    {
        try {
            $detalle = DB::select(
                'exec piap_qj_documadmin_detalle ?',
                [$id]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $detalle,

            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function lista_notificacion(string $anio, string $numero, string $pase, int $area, string $tipo)
    {
        try {

            $notificacionlistado = DB::select(
                'exec piap_qj_documadmin_lista ?,?,?,?,?,?,?,?',
                [$area, null, null, null, $tipo, $anio, $numero, $pase]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'notificalista' => $notificacionlistado,
            ];


            return [
                'success' => true,
                'mensaje' => '',
                'data' => $detalle,

            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function elimina_notificacion(int $id, array $user)
    {
        try {
            $usuario = $user['data']['username_magic'];
            $elimina = DB::select(
                'exec piap_qj_documadmin_eliminar ?,?',
                [$id, $usuario]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'elimina' => $elimina,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function cerrar_expediente(array $datos)
    {
        try {
            $idareauauario = 0;


            if ($datos['datos']['id'] == 1) {
                $area = DB::select(
                    'exec piap_qj_tramite_area_usuario ?',
                    [$datos['JWT_username']]
                );
                $idareauauario = $area[0]->idarea;
            }
            $idarea = $datos['datos']['id'] == 1 ? $idareauauario : $datos['datos']['area'];
            $cerrar = DB::select(
                'exec piap_qj_tramite_entrada_derivar ?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                [$datos['datos']['ano'], $datos['datos']['codigo'], $datos['datos']['item'], $datos['datos']['organig'], $idarea, $datos['datos']['accion'], $datos['datos']['folio'], $datos['datos']['observacion'], $datos['datos']['tipdoc_pase'], $datos['datos']['anodoc_pase'], $datos['datos']['nrodoc_pase'], $datos['datos']['siglasdoc_pase'], $datos['datos']['fechadoc_pase'], $datos['JWT_username']]
            );
            // $cerrar = [];
            return [
                'success' => true,
                'mensaje' => '',
                'data' => $cerrar,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_derivacion(array $data)
    {
        try {
            $item_x_page = $item_x_page ?? 10;

            $area = DB::select(
                'exec piap_qj_areas_lista ?,?',
                [0, 1]
            );
            $accion = DB::select(
                'exec piap_qj_acciones_lista',
                [0, 1]
            );


            return [
                'success' => true,
                'mensaje' => '',
                'listaccion' => $accion,
                'listaarea' => $area
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
}
