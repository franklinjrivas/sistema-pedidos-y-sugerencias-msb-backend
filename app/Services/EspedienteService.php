<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\AuditoriaSistemaService;
use App\Models\tramite;
use App\Models\expediente;
use App\Models\expediente_det;

class EspedienteService
{
    private $auditoriaSistemaService;

    public function __construct(AuditoriaSistemaService $auditoriaSistemaService)
    {
        $this->auditoriaSistemaService = $auditoriaSistemaService;
    }
    public function grabar_expediente(array $datos)
    {
        $tipo = $datos['data'][0]['idtipo'];
        $ano = $datos['data'][0]['ano'];
        $codigo = $datos['data'][0]['codigo'];
        $organig = isset($datos['data'][0]['organig'])? strval($datos['data'][0]['organig']):null;
        $tupa = $datos['data'][0]['tupa']?$datos['data'][0]['tupa']:null;
        $area = $datos['data'][0]['area']?$datos['data'][0]['area']:null;
        $motivo = $datos['data'][0]['motivo']?$datos['data'][0]['motivo']:null;
        $canal = $datos['data'][0]['canal']?$datos['data'][0]['canal']:null;
        $ctrb = $datos['data'][0]['ctrb']?$datos['data'][0]['ctrb']:null;
        $notifica_direccion = $datos['data'][0]['notificaenm']?$datos['data'][0]['notificaenm']:null;
        $notifica_email = $datos['data'][0]['correo']?$datos['data'][0]['correo']:null;
        $folios = null;
        $observaciones = $datos['data'][0]['detalle']?$datos['data'][0]['detalle']:null;
        $catastro = $datos['data'][0]['catastro']?$datos['data'][0]['catastro']:null;
        $tipo_documento = $datos['data'][0]['tipo_documento']?$datos['data'][0]['tipo_documento']:null;
        $ano_documento = $datos['data'][0]['ano_documento']?$datos['data'][0]['ano_documento']:null;
        $nro_documento = $datos['data'][0]['nro_documento']?$datos['data'][0]['nro_documento']:null;
        $usuario=$datos['JWT_username'];
        $sede = $datos['data'][0]['sede']?$datos['data'][0]['sede']:null;

        $listarpersona = DB::statement(
            'exec piap_qj_mesaparte_tramite_actualiza ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            [$tipo,$ano ,$codigo,$organig,$tupa, $area,$motivo , $canal ,  $ctrb, $notifica_direccion,  $notifica_email,$folios,$observaciones ,$catastro ,$tipo_documento,$ano_documento ,$nro_documento , $usuario, $sede]
        );
        if ($listarpersona == 1) {
            $accion = $codigo == 0 ? 'I' : 'U';
            if ($codigo == 0) {
                $modelo = tramite::orderBy('fechor_crea', 'desc')->first();
                $creaexpediente = expediente::where('ANO_TRAMITE', $modelo->ano)->where('NRO_TRAMITE', $modelo->codigo)->first();
                $this->auditoriaSistemaService->save_log_auditoria_dml(null, $creaexpediente, null, $accion);
            }else {
                $modelo = tramite::where('ano', $ano)->where('codigo', $codigo)->first();
            }
            $this->auditoriaSistemaService->save_log_auditoria_dml(null, $modelo, null, $accion);
        }
        return [
            'success' => true,
            'mensaje' => '',
            'data' => $listarpersona
        ];
    }
     public function confirmar_expediente(string $user, array $datos)

    {
        $listarpersona = DB::statement(
            'exec piap_qj_mesaparte_tramite_confirmar ?,?,?,?',
            [$datos['tipo'],$datos['anio'] ,$datos['numero'],$datos['JWT_username']]
        );
        if ($listarpersona == 1) {
            $modificatramite = tramite::where('codigo',$datos['numero'] )->where('ano', $datos['anio'])->first();
            $this->auditoriaSistemaService->save_log_auditoria_dml(null, $modificatramite, null, 'U');
            $modificatramitedetalle = expediente_det::where('CODIGO',$datos['numero'] )->where('ANO', $datos['anio'])->first();
            $this->auditoriaSistemaService->save_log_auditoria_dml(null, $modificatramitedetalle, null, 'I');
        }

        return [
            'success' => true,
            'mensaje' => 'SE CONFIRMÓ REGISTRO CON ÉXITO',
            'data' => $listarpersona
        ];
    }
    public function extornar_expediente(array $datos)
    {
        $data = [];
        $data = DB::statement(
            'exec piap_qj_mesaparte_pendientes_extornar ?,?,?',
            [$datos['anio'] ,$datos['numero'],$datos['pase']]
        );
        if ($data == 1) {
            $modificatramite = tramite::where('codigo',$datos['numero'] )->where('ano', $datos['anio'])->first();
            $this->auditoriaSistemaService->save_log_auditoria_dml(null, $modificatramite, null, 'U');
        }
        return [
            'success' => true,
            'mensaje' => 'SE EXTORNO REGISTRO CON ÉXITO',
            'data' => $data
        ];
    }
    public function anula_expediente(array $datos)
    {
        $data = [];
        $data = DB::statement(
            'exec piap_qj_mesaparte_tramite_eliminar ?,?',
            [$datos['anio'] ,$datos['numero']]
        );
        if ($data == 1) {
            $anulaexpediente = tramite::where('codigo',$datos['numero'] )->where('ano', $datos['anio'])->first();
            $this->auditoriaSistemaService->save_log_auditoria_dml(null, $anulaexpediente, null, 'D');
        }
        return [
            'success' => true,
            'mensaje' => 'SE EXTORNO REGISTRO CON ÉXITO',
            'data' => $data
        ];
    }
}
