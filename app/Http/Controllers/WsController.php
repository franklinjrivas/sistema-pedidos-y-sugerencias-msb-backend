<?php

namespace App\Http\Controllers;
use App\Exports\V1_BI_RegistrosReporteExport;
use Illuminate\Http\Request;
use App\Services\WsService;
use Maatwebsite\Excel\Facades\Excel;

class WsController extends Controller
{
    private $wsService;
    public function __construct(WsService $wsService)
    {
        $this->wsService = $wsService;
    }
    public function v1_bi_excel_registros_reportes(Request $request)
    {
        try {
            $datos =  $request->all();
            $regitros = $this->wsService->v1_bi_registros_reporte($datos);
            return Excel::download(new V1_BI_RegistrosReporteExport($regitros), 'reporte.xlsx',\Maatwebsite\Excel\Excel::XLSX);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
