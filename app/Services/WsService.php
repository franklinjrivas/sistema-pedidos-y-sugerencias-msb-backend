<?php

namespace App\Services;

use App\Models\ValoresIndicadoresMensuales;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;
use App\Services\DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class WsService
{
    public function v1_bi_registros_reporte(?array $datos)
    {
        $area = $datos['area']?$datos['area']:0;
        $motivo = $datos['motivo']?$datos['motivo']:0;
        $fec_ini = $datos['fec_ini'];
        $fec_fin = $datos['fec_fin'];
        $tipo_doc = $datos['tipo_doc']?$datos['tipo_doc']:0;
        $tipo_canal = $datos['tipo_canal']?$datos['tipo_canal']:0;
        $fecha1_ = \DateTime::createFromFormat('d/m/Y', str_replace('-', '/', $fec_ini));
        $fecha2_ = \DateTime::createFromFormat('d/m/Y', str_replace('-', '/', $fec_fin));
        if (!$fecha1_) $fecha1_ = new \DateTime();
        if (!$fecha2_) $fecha2_ = new \DateTime();
        $fecha1 = $fecha1_->format('d/m/Y');
        $fecha2 = $fecha2_->format('d/m/Y');
        $rscanal = DB::select(
            'exec piap_qj_reporte_ingresos_por_area ?,?,?,?,?,?',
            [$area, $motivo, $fecha1, $fecha2, $tipo_doc, $tipo_canal ]
        );
        $datos = [
            'data' =>  $rscanal,
            'desde' => $fecha1,
            'hasta' => $fecha2,
        ];
        return $datos;
    }
}
