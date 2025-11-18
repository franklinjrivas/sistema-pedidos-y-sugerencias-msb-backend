<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Services\DateTime;

class ReportesService
{
    public function listar_por_fechas(?array $datos)
    {
        $desde = $datos['datos']['desde'];
        $hasta = $datos['datos']['hasta'];
        $formato = $datos['datos']['formato'] ?? null;
        if ($formato) {
            $listaporfecha = DB::select(
                'exec piap_qj_tramite_fechas ?,?',
                [$desde, $hasta]
            );
            $param = [
                'data' => $listaporfecha,
                'desde' => $desde,
                'hasta' => $hasta,
            ];

            $pdf = PDF::loadView('plantillas-pdf.porfechas', $param)->setPaper('a4', 'landscape');
            $content = $pdf->output();
            $base64 = base64_encode($content);
            return $base64;
        } else {
            $listaporfecha = DB::select(
                'exec piap_qj_tramite_fechas ?,?',
                [$desde, $hasta]
            );
        }
        return [
            'success' => true,
            'mensaje' => '',
            'data' => $listaporfecha
        ];
    }
    public function listar_por_area(?array $datos)
    {
        $motivo = $datos['datos']['motivo'];
        $fec_ini = $datos['datos']['desde'];
        $fec_fin = $datos['datos']['hasta'];
        $tipo_doc = $datos['datos']['tipo'];
        $tipo_canal = $datos['datos']['canal'];
        $listaporarea = DB::select(
            'exec piap_qj_reporte_resumen_ingresos_por_area ?,?,?,?,?',
            [$motivo, $fec_ini, $fec_fin, $tipo_doc, $tipo_canal]
        );
        $param = [
            'data' => $listaporarea,
            'desde' => $fec_ini,
            'hasta' => $fec_fin,
        ];
        $pdf = PDF::loadView('plantillas-pdf.porarea', $param)->setPaper('a4');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function lista_registro_por_area_pendientes(?array $datos)
    {
        $area = $datos['datos']['area'];
        $fec_ini = $datos['datos']['desde'];
        $fec_fin = $datos['datos']['hasta'];
        $canal = $datos['datos']['canal'];
        $rstArea = DB::select(
            'exec piap_trw_areageneral_actual_pdf ?',
            [$area]
        );
        $areasolicitud = $rstArea[0]->DESCRIPCION ?? null;
        $rscanal = DB::select(
            'exec piap_qj_buscar_canal ?',
            [$canal]
        );
        $canaldes = $rscanal[0]->DESCRIPCION ?? null;
        $rstReporte = DB::select(
            ' exec piap_qj_reporte_ingresos_por_area_no_resueltos ?,?,?,?,?,?',
            [$area, 0, $fec_ini, $fec_fin, 0, $canal]
        );
        $param = [
            'data' =>  $rstReporte,
            'desde' => $fec_ini,
            'hasta' => $fec_fin,
            'area' => $areasolicitud,
            'canal' => $canaldes,
        ];

        $pdf = PDF::loadView('plantillas-pdf.pendientesporarea', $param)->setPaper('a4', 'landscape');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function lista_registro_por_area_pendientes_resumen(?array $datos)
    {
        $motivo = $datos['datos']['motivo'];
        $fec_ini = $datos['datos']['desde'];
        $fec_fin = $datos['datos']['hasta'];

        $rstAreaResumen = DB::select(
            'exec piap_qj_reporte_resumen_ingresos_por_area ?,?,?,?,?',
            [$motivo, $fec_ini, $fec_fin, 0, 1]
        );
        $param = [
            'data' =>  $rstAreaResumen,
            'desde' => $fec_ini,
            'hasta' => $fec_fin,
            'motivo' => $motivo,
        ];

        $pdf = PDF::loadView('plantillas-pdf.resumenpendientesporarea', $param)->setPaper('a4');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function lista_resumen_alertas(?array $datos)
    {
        $area = $datos['datos']['area'];
        $fec_ini = $datos['datos']['desde'];
        $fec_fin = $datos['datos']['hasta'];
        $tipo = $datos['datos']['tipo'];
        $rstarea = DB::select(
            'exec piap_trw_areageneral_actual ?',
            [$area]
        );
        $detarea = $area === 0 ? 'DE TODAS LAS AREAS' : 'DEL AREA: ' . $rstarea[0]->DESCRIPCION;
        $rstalertas = DB::select(
            'exec piap_qj_reporte_alertas_por_area_tipo_test ?,?,?,?,?',
            [$area,$tipo , $fec_ini, $fec_fin, 1 ]
        );
        $param = [
            'data' =>  $rstalertas,
            'desde' => $fec_ini,
            'hasta' => $fec_fin,
            'idarea' => $area,
            'area' => $detarea,
        ];
        $pdf = PDF::loadView('plantillas-pdf.resumenalertas', $param)->setPaper('a4', 'landscape');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function buscar_contribuyente(?Int $id)
    {
        $data = DB::select(
            'exec piap_qj_tramite_administrado ?',
            [$id]
        );
        return [
            'data' => $data
        ];
    }
    public function buscar_documentos_recepcionados(?array $datos)
    {
        $rstArea = [];
        $areasolicitud = [];
        $rscanal = [];
        $area = $datos['datos']['area']?$datos['datos']['area']:0;
        $motivo = $datos['datos']['motivo']?$datos['datos']['motivo']:0;
        $fec_ini = $datos['datos']['fec_ini'];
        $fec_fin = $datos['datos']['fec_fin'];
        $tipo_doc = $datos['datos']['tipo_doc']?$datos['datos']['tipo_doc']:0;
        $tipo_canal = $datos['datos']['tipo_canal']?$datos['datos']['tipo_canal']:0;
        $fecha1_ = \DateTime::createFromFormat('d/m/Y', str_replace('-', '/', $fec_ini));
        $fecha2_ = \DateTime::createFromFormat('d/m/Y', str_replace('-', '/', $fec_fin));
        if (!$fecha1_) $fecha1_ = new \DateTime();
        if (!$fecha2_) $fecha2_ = new \DateTime();
        $fecha1 = $fecha1_->format('d/m/Y');
        $fecha2 = $fecha2_->format('d/m/Y');
        $rstArea = DB::select(
            'exec piap_qj_areageneral_actual ?',
            [$area]
        );
        $areasolicitud = $rstArea[0]->DESCRIPCION ?? null;
        $detarea = $area === 0 || !$area ? 'DE TODAS LAS AREAS' : 'DEL AREA: ' . $areasolicitud;

        $rscanal = DB::select(
            'exec piap_qj_reporte_ingresos_por_area ?,?,?,?,?,?',
            [$area, $motivo, $fecha1 ,$fecha2, $tipo_doc, $tipo_canal ]
        );
        $param = [
            'data' =>  $rscanal,
            'desde' => $fec_ini,
            'hasta' => $fec_fin,
            'area' => $detarea,
        ];

        $pdf = PDF::loadView('plantillas-pdf.docrecepcionados', $param)->setPaper('a4', 'landscape');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function buscar_parte_diario(?array $datos)
    {
        $fecha1 = $datos['datos']['fecha'];
        $fecha2 = Carbon::parse($fecha1);
        $fecha2->setTimezone('America/Lima');
        $fecha =  $fecha2->format('d/m/Y');
        $rstAreaResumen = DB::select(
            'exec piap_qj_mesaparte_tramite_imp_lista ?',
            [$fecha]
        );
        $param = [
            'data' =>  $rstAreaResumen,
        ];

        $pdf = PDF::loadView('plantillas-pdf.partediario', $param)->setPaper('a4', 'landscape');
        $content = $pdf->output();
        $base64 = base64_encode($content);
        return $base64;
    }
    public function consultar_expediente(?array $datos)
    {
        $anio = $datos['anio'];
        $codigo = $datos['codigo'];
        $item = $datos['pase'];
        $data = DB::select(
            'exec piap_qj_tramite_detalle ?,?,?',
            [$anio, $codigo, $item]
        );
        return $param = [
            'data' =>  $data,
        ];
    }
    public function consultar_informacion_documento(?array $datos)
    {
        $anio = $datos['anioinfo'];
        $codigo = $datos['codigoinfo'];
        $tipo = $datos['tipoinfo'];
        $data = DB::select(
            'exec piap_qj_documadmin_lista ?,?,?,?,?,?,?,?',
            [null, null, null, null,$tipo, (string) $anio, $codigo,null]
        );
        return $param = [
            'data' =>  $data,
        ];
    }
    public function data_correos(array $datos)
    {
        $data = DB::select(
            'exec piap_qj_tramite_detalle ?,?,?',
            [$datos['anio'],$datos['codigo'],$datos['pase']]
        );
        return [
            'success' => true,
            'mensaje' => 'SE CONFIRMÓ REGISTRO CON ÉXITO',
            'data' => $data
        ];
    }
}
