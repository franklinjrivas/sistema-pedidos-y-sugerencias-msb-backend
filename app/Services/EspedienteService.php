<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EspedienteService
{

    public function grabar_expediente(array $datos, ?string $user)
    {
        try {
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
            $usuario=$user;
            $sede = $datos['data'][0]['sede']?$datos['data'][0]['sede']:null;

            $listarpersona = DB::statement(
                'exec piap_qj_mesaparte_tramite_actualiza ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                [$tipo,$ano ,$codigo,$organig,$tupa, $area,$motivo , $canal ,  $ctrb, $notifica_direccion,  $notifica_email,$folios,$observaciones ,$catastro ,$tipo_documento,$ano_documento ,$nro_documento , $usuario, $sede]
            );

            return [
                'success' => true,
                'mensaje' => '',
                'data' => $listarpersona
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
     public function confirmar_expediente(array $usermagic, array $datos)

    {
        // $usermagic['data']['username_magic']
        try {
            $listarpersona = DB::statement(
                'exec piap_qj_mesaparte_tramite_confirmar ?,?,?,?',
                [$datos['tipo'],$datos['anio'] ,$datos['numero'],$datos['JWT_username']]
            );
            return [
                'success' => true,
                'mensaje' => 'SE CONFIRMÓ REGISTRO CON ÉXITO',
                'data' => $listarpersona
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

    public function extornar_expediente(array $datos)
    {
        try {
            $data = [];
            $data = DB::statement(
                'exec piap_qj_mesaparte_pendientes_extornar ?,?,?',
                [$datos['anio'] ,$datos['numero'],$datos['pase']]
            );
            return [
                'success' => true,
                'mensaje' => 'SE EXTORNO REGISTRO CON ÉXITO',
                'data' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }
    public function anula_expediente(array $datos)
    {
        try {
            $data = [];
            $data = DB::statement(
                'exec piap_qj_mesaparte_tramite_eliminar ?,?',
                [$datos['anio'] ,$datos['numero']]
            );
            return [
                'success' => true,
                'mensaje' => 'SE EXTORNO REGISTRO CON ÉXITO',
                'data' => $data
            ];
        } catch (\Throwable $e) {
            Log::info($e->getMessage());
        }
    }

}
