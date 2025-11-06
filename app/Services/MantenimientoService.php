<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MantenimientoService
{


    public function listar_areas_insertar_motivos()
    {
        try {
            $area = DB::select(
                'exec piap_trw_areas_lista ?,?',
                [0, 1]
            );
            return [
                'area' => $area
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_tipo_mantenimiento()
    {
        try {
            $listtipos = DB::select(
                'exec piap_qj_tipo_mantenimiento ',
                []
            );
            $area = DB::select(
                'exec piap_trw_areas_lista ?,?',
                [0, 1]
            );
            $tipos = DB::select(
                'exec piap_qj_tipodocpresentado_lista ? ',
                [0]
            );
            return [
                'data' => $listtipos,
                'tipos' => $tipos,
                'area' => $area
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_tipo_detalla_mantenimiento(?array $datos)
    {
        try {
            $area = $datos['area'] != 0 ? $datos['area'] : null;
            $tipoqueja = $datos['tipoqueja'] ?? null;
            $listados = DB::select(
                'exec piap_qj_motivos_lista ?,?',
                [$tipoqueja, $area]
            );

            return [
                'data' => $listados,
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_data_mantenimiento(?array $datos)
    {
        try {
            switch ($datos['id']) {
                case '1':
                    $data = DB::select(
                        'exec piap_qj_acciones_lista ',
                        []
                    );
                    break;
                case '2':
                    $data = DB::select(
                        'exec piap_qj_estados_lista ',
                        []
                    );
                    break;
                case '3':
                    $data = DB::select(
                        'exec piap_qj_motivos_lista ',
                        []
                    );
                    break;
                case '4':
                    $data = DB::select(
                        'exec piap_qj_tiporesultados_lista ',
                        []
                    );
                    break;
            }
            return [
                'data' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function eliminar_mantenimiento(?array $datos, ?string $usuario)
    {
        try {
            switch ($datos['id']) {
                case '1':
                    $data = DB::select(
                        'exec piap_qj_acciones_eliminar ?,? ',
                        [$datos['codigo'], $usuario]
                    );
                    break;
                case '2':
                    $data = DB::select(
                        'exec piap_qj_estados_eliminar ?,? ',
                        [$datos['codigo'], $usuario]
                    );
                    break;
                case '3':
                    $data = DB::select(
                        'exec piap_qj_motivos_eliminar ?,?',
                        [$datos['codigo'], $usuario]
                    );

                    break;
                case '4':
                    $data = DB::select(
                        'exec piap_qj_tiporesultados_eliminar ?,? ',
                        [$datos['codigo'], $usuario]
                    );
                    break;
            }
            return [
                'data' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function guardar_mantenimiento(?array $datos)
    {
        try {
            $id = $datos['data'][0]['id'];
            $usuario = $datos['JWT_username'];
            $codigo =   $datos['data'][0]['codigo'] ? $datos['data'][0]['codigo'] : 0;
            $descripcion = $datos['data'][0]['descripcion'];
            $tipoqueja = $datos['data'][0]['tipoqueja'];
            $area = $datos['data'][0]['area'];
            $estado = $datos['data'][0]['estado'];
            $idmotivo = $datos['data'][0]['idmotivo'];

            switch ($id) {
                case '1':
                    $data = DB::select(
                        'exec piap_qj_acciones_actualiza ?,?,?',
                        [$codigo, $descripcion, $usuario]
                    );
                    break;
                case '2':
                    $data = DB::select(
                        'exec piap_qj_estados_actualiza ?,?,? ',
                        [$codigo, $descripcion, $usuario]
                    );
                    break;
                case '3':
                    $data = DB::select(
                        'exec piap_qj_motivos_actualiza ?,?,?,?,?,?,? ',
                        [ $idmotivo,  $tipoqueja , $area, $codigo, $descripcion, $estado, $usuario]
                    );
                    break;
                case '4':
                    $data = DB::select(
                        'exec piap_qj_tiporesultados_actualiza ?,?,?',
                        [$codigo, $descripcion, $usuario]
                    );
                    break;
            }
            return [
                'data' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
}
