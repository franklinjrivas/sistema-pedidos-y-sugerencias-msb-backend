<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\persona;
use App\Models\direccioncontri;
use App\Services\AuditoriaSistemaService;
class PersonaService
{
    private $auditoriaSistemaService;

    public function __construct(AuditoriaSistemaService $auditoriaSistemaService)
    {
        $this->auditoriaSistemaService = $auditoriaSistemaService;
    }
    public function listar_personas(?string $codigo, ?string $numerodoctit, ?string $apepaternotit, ?string $apematernotit, ?string $nombretit, ?string $numerodocon, ?string $apepaternocon, ?string $apematernocon, ?string $nombrecon)
    {
        $listarpersona = DB::select(
            'exec piap_sp_persona_lista ?,?,?,?,?,?,?,?,?',
            [$codigo, $numerodoctit, $apepaternotit,  $apematernotit, $nombretit, $numerodocon, $apepaternocon, $apematernocon, $nombrecon]
        );

        return [
            'success' => true,
            'mensaje' => '',
            'listtipo' => $listarpersona
        ];
    }

    public function listar_doc_identidad()
    {
        $listardocidentidad = DB::select(
            'exec piap_sp_tipdocidentidad_lista',
            []
        );

        return [
            'success' => true,
            'mensaje' => '',
            'listtipo' => $listardocidentidad
        ];
    }

    public function listar_motivos(?int $id, ?int $area)
    {
        $listmotivos = DB::select(
            'exec piap_qj_motivos_lista_por_area ?,?,?',
            [$id, $area,1]
        );
        return [
            'success' => true,
            'mensaje' => '',
            'listmotivo' => $listmotivos
        ];
    }
    public function listar_departamentos()
    {
        $listardepartamentos = DB::select(
            'exec piap_sp_dpto_lista ?',
            [null]
        );
        return [
            'success' => true,
            'mensaje' => '',
            'listdpto' => $listardepartamentos
        ];
    }

    public function listar_provincias(?string $id, ?string $des)
    {
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
    }

    public function listar_distritos(?string $id, ?string $des)
    {
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
    }
    public function listar_urbanizaciones()
    {
        $listarurbanizaciones = DB::select(
            'exec piap_sp_urbanizacion_lista',
            []
        );
        return [
            'success' => true,
            'mensaje' => '',
            'listurb' => $listarurbanizaciones
        ];
    }
    public function listar_vias(?string $ubigeo)
    {
        $listarrvias = DB::select(
            'exec piap_sp_PreviasD_lista ?',
            [$ubigeo]
        );
        return [
            'success' => true,
            'mensaje' => '',
            'listvias' => $listarrvias
        ];
    }
    public function detalle_documento(?string $anio, ?string $codigo, ?string $tipo)
    {
        $detalle = DB::select(
            'exec piap_qj_mesaparte_tramite_detalle ?,?',
            [$anio, $codigo]
        );
        return [
            'success' => true,
            'mensaje' => '',
            'datadocumento' => $detalle
        ];
    }

    public function listar_interiores()
    {
        $listarinteriores = DB::select(
            'exec piap_sp_TipInterior_lista',
            []
        );
        return [
            'success' => true,
            'mensaje' => '',
            'listint' => $listarinteriores
        ];
    }

    public function guardar_contribuyente(array $data, string $user)
    {
        // $usuario = $user;
        $usuario = 'frivas';
        $co_ctrb = $data['data'][0]['codigoT'] ? $data['data'][0]['codigoT'] : 0;
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
        if (!empty($guardado) && !empty($guardado[0]) && $guardado[0]->DML == 'I' ) {
            $ultimoCodigo = persona::max('CO_CTRB');
            if ($ultimoCodigo) {
                $persona = persona::where('CO_CTRB', $ultimoCodigo)->first();
                $this->auditoriaSistemaService->save_log_auditoria_dml(null, $persona, null, $guardado[0]->DML);
                $direccion = direccioncontri::where('CO_CTRB', $ultimoCodigo)->first();
                $this->auditoriaSistemaService->save_log_auditoria_dml(null, $direccion, null, $guardado[0]->DML);
            }
        }
        return [
            'respuesta_guardado' => $guardado
        ];
    }
}
