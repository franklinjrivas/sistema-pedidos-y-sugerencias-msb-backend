<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class PDFService
{

    private $pantillasPDF;

    public function __construct()
    {
        $this->pantillasPDF = 'plantillas-pdf.';
    }

    public function formatos($tipo, $anio,$codigo, $tipo_pdf, $output_base64 = true, $output_stream = false)
    {
        if ($tipo_pdf == '1' || $tipo_pdf == '2' ) {
            $detalle_cargo = DB::select(
                'exec piap_qj_mesaparte_tramite_detalle ?,?',
                [$anio,$codigo]
            );
            $data = [
                'data' => $detalle_cargo[0]
            ];
        }   else {

            $detalle_email = DB::select(
                'exec piap_qj_tramite_detalle ?,?,?',
                [$anio,$codigo,$tipo]
            );
            $data = [
                'data' => $detalle_email[0]
            ];
        }
        switch ($tipo_pdf) {
            case '1':
                if ($output_base64) {
                    $pdf = PDF::loadView($this->pantillasPDF . 'cargo', $data)->setPaper('a4','portrait');
                    $content = $pdf->output();
                    $base64 = base64_encode($content);
                    return $base64;
                }
                break;
            case '2':
                if ($output_base64) {
                    $pdf = PDF::loadView($this->pantillasPDF . 'partediario', $data)->setPaper('a4');
                    $content = $pdf->output();
                    $base64 = base64_encode($content);
                    return $base64;
                }
                break;
            case '3':
                if ($output_base64) {
                    $pdf = PDF::loadView($this->pantillasPDF . 'dataemail', $data)->setPaper('a4');
                    $content = $pdf->output();
                    $base64 = base64_encode($content);
                    return $base64;
                }
                break;
            default:
                throw new \Exception('error no se encontro el formato');
                break;
        }
        if ($output_stream) {
            return Pdf::loadView($this->pantillasPDF . $tipo_pdf, $data)
                ->setPaper('a4')
                ->stream('solicitud.pdf');
        }
    }
}
