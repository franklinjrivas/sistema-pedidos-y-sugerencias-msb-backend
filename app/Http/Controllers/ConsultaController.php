<?php

namespace App\Http\Controllers;

use App\Services\ConsultaService;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    private $ConsultaService;

    public function __construct(ConsultaService $ConsultaService)
    {
        $this->ConsultaService = $ConsultaService;
    }

    public function listtipos(Request $request)
    {
        try {

            $listado = $this->ConsultaService->list_personas();
            return response()->json([
                'success' => true,
                'mensaje' => 'Valores de Indicadores completo',
                'data' =>   $listado
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listrecepcion(Request $request)
    {
        try {
            $fecha_utc = $request->fecha;
            $fecha_ = new DateTime($fecha_utc);
            $fecha = $fecha_->format('d/m/Y');
            $idtipo = $request->tipo;
            $idcanal = $request->canal;
            $idsede = $request->sede?$request->sede:0;
            $recepcion = $this->ConsultaService->list_recepcion($fecha, $idtipo, $idcanal,$idsede );
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $recepcion
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

}
