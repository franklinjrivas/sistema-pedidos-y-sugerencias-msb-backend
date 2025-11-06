<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonaService
{

    public function listar_personas(?string $codigo, ?string $numerodoctit, ?string $apepaternotit, ?string $apematernotit, ?string $nombretit, ?string $numerodocon, ?string $apepaternocon, ?string $apematernocon, ?string $nombrecon)
    {
        try {
            $listarpersona = DB::select(
                'exec piap_sp_persona_lista ?,?,?,?,?,?,?,?,?',
                [$codigo, $numerodoctit, $apepaternotit,  $apematernotit, $nombretit, $numerodocon, $apepaternocon, $apematernocon, $nombrecon]
            );

            return [
                'success' => true,
                'mensaje' => '',
                'listtipo' => $listarpersona
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function listar_doc_identidad()
    {
        try {

            $listardocidentidad = DB::select(
                'exec piap_sp_tipdocidentidad_lista',
                []
            );

            return [
                'success' => true,
                'mensaje' => '',
                'listtipo' => $listardocidentidad
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function listar_motivos(?int $id, ?int $area)
    {
        try {
            $listmotivos = DB::select(
                'exec piap_qj_motivos_lista_por_area ?,?,?',
                [$id, $area,1]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listmotivo' => $listmotivos
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_departamentos()
    {
        try {
            $listardepartamentos = DB::select(
                'exec piap_sp_dpto_lista ?',
                [null]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listdpto' => $listardepartamentos
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function listar_provincias(?string $id, ?string $des)
    {
        try {
            $desc = $des ? $des : null;

            $listprovincias = DB::select(
                'exec piap_sp_prov_lista ?,?',
                [$id, $desc]
            );

            return [
                'success' => true,
                'mensaje' => '',
                'listprov' => $listprovincias
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }


    public function listar_distritos(?string $id, ?string $des)
    {
        try {

            $desc = $des ? $des : null;

            $listdistritos = DB::select(
                'exec piap_sp_dist_lista ?,?',
                [$id, $desc]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listdist' => $listdistritos
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_urbanizaciones()
    {
        try {

            $listarurbanizaciones = DB::select(
                'exec piap_sp_urbanizacion_lista',
                []
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listurb' => $listarurbanizaciones
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function listar_vias(?string $ubigeo)
    {
        try {
            $listarrvias = DB::select(
                'exec piap_sp_PreviasD_lista ?',
                [$ubigeo]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listvias' => $listarrvias
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function detalle_documento(?string $anio, ?string $codigo, ?string $tipo)
    {
        try {
            $detalle = DB::select(
                'exec piap_qj_mesaparte_tramite_detalle ?,?',
                [$anio, $codigo]
            );
            return [
                'success' => true,
                'mensaje' => '',
                'datadocumento' => $detalle
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function listar_interiores()
    {
        try {

            $listarinteriores = DB::select(
                'exec piap_sp_TipInterior_lista',
                []
            );
            return [
                'success' => true,
                'mensaje' => '',
                'listint' => $listarinteriores
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function guardar_contribuyente(array $data, array $user)
    {
        try {
            $usuario = $user['data']['username_magic'];
            $co_ctrb = $data['data'][0]['codigoT'] ? $data['data'][0]['codigoT'] : null;
            $tipo_persona = $data['data'][0]['tipoper'] ? $data['data'][0]['tipoper'] : null;
            $apepat = $data['data'][0]['apellidoPT'] ? $data['data'][0]['apellidoPT'] : null;
            $apemat = $data['data'][0]['apellidoMT'] ? $data['data'][0]['apellidoMT'] : null;
            $nombres = $data['data'][0]['nombreT'] ? $data['data'][0]['nombreT'] : null;
            $email = $data['data'][0]['correo'] ? $data['data'][0]['correo'] : null;
            $telefono = $data['data'][0]['telefonoT'] ? $data['data'][0]['telefonoT'] : null;
            $tipodoc = $data['data'][0]['tipodoc'] ? $data['data'][0]['tipodoc'] : null;
            $nrodoc = $data['data'][0]['numdocumento'] ? $data['data'][0]['numdocumento'] : null;
            $ubigeo = $data['data'][0]['distnum'] ? $data['data'][0]['distnum'] : null;
            $urbanizacion = $data['data'][0]['urbanizacion'] ? $data['data'][0]['urbanizacion'] : null;
            $manzana = $data['data'][0]['manzana'] ? $data['data'][0]['manzana'] : null;
            $lote = $data['data'][0]['lote'] ? $data['data'][0]['lote'] : null;
            $via = $data['data'][0]['tipovia'] ? $data['data'][0]['tipovia'] : null;
            $numero = $data['data'][0]['numero'] ? $data['data'][0]['numero'] : null;
            $tipinterior = $data['data'][0]['tipoint'] ? $data['data'][0]['tipoint'] : null;
            $interior = $data['data'][0]['interior'] ? $data['data'][0]['interior'] : null;
            $apepat_conyuge = $data['data'][0]['apellidoPC'] ? $data['data'][0]['apellidoPC'] : null;
            $apemat_conyuge = $data['data'][0]['apellidoMC'] ? $data['data'][0]['apellidoMC'] : null;
            $nombres_conyuge = $data['data'][0]['nombreC'] ? $data['data'][0]['nombreC'] : null;
            $tipodoc_conyuge = $data['data'][0]['tipodoccon'] ? $data['data'][0]['tipodoccon'] : null;
            $nrodoc_conyuge = $data['data'][0]['numdocumentocon'] ? $data['data'][0]['numdocumentocon'] : null;
            $sector = $data['data'][0]['sector'] ? $data['data'][0]['sector'] : null;
            $creado = null;

            $guardado = DB::select(
                'exec piap_sp_persona_grabar ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                [$co_ctrb, $tipo_persona, $apepat, $apemat, $nombres, $email, $telefono, $tipodoc, $nrodoc, $ubigeo, $urbanizacion, $manzana, $lote, $via, $numero, $tipinterior, $interior, $apepat_conyuge, $apemat_conyuge, $nombres_conyuge, $tipodoc_conyuge, $nrodoc_conyuge, $usuario, $sector, $creado]
            );

            return [
                'respuesta_guardado' => $guardado
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
}
