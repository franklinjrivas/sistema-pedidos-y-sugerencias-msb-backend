<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\ReportesService;

class ReportesController extends Controller
{
    private $ReportesService;
    private $authService;

    public function __construct(
        ReportesService $ReportesService,
        AuthService $authService
    )
    {
        $this->ReportesService = $ReportesService;
        $this->authService = $authService;
    }

    public function lista_registro_por_fechas(Request $request)
    {
            $datos =  $request->all();
            $listarporfecha = $this->ReportesService->listar_por_fechas($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporfecha
            ]);
    }
    public function lista_registro_por_area(Request $request)
    {
            $datos =  $request->all();
            $listarporarea = $this->ReportesService->listar_por_area($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporarea
            ]);
    }
    public function lista_registro_por_area_pendientes(Request $request)
    {
            $datos =  $request->all();
            $listarporarea = $this->ReportesService->lista_registro_por_area_pendientes($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporarea
            ]);
    }
    public function lista_registro_por_area_pendientes_resumen(Request $request)
    {
            $datos =  $request->all();
            $resumenexpedientependientes = $this->ReportesService->lista_registro_por_area_pendientes_resumen($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $resumenexpedientependientes
            ]);
    }
    public function lista_resumen_alertas(Request $request)
    {
            $datos =  $request->all();
            $listaalertas = $this->ReportesService->lista_resumen_alertas($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listaalertas
            ]);
    }
    public function buscar_contribuyente(Request $request)
    {
            $id = $request->id;
            $contribuyente = $this->ReportesService->buscar_contribuyente($id);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $contribuyente
            ]);
    }
    public function buscar_parte_diario(Request $request)
    {
            $datos =  $request->all();
            $recepcionados = $this->ReportesService->buscar_parte_diario($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $recepcionados
            ]);
    }
    public function consultar_expediente(Request $request)
    {
            $datos =  $request->all();
            $expedientes = $this->ReportesService->consultar_expediente($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Expediente Encontrado',
                'data' => $expedientes
            ]);
    }

    public function consultar_data_email(Request $request)
    {
            $datos =  $request->all();

            $datacorreos = $this->ReportesService->data_correos($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Data obtenida de manera correcta',
                'data' =>   $datacorreos
            ]);
    }
    public function buscar_documentos_recepcionados(Request $request)
    {
            $datos =  $request->all();
            $datacorreos = $this->ReportesService->buscar_documentos_recepcionados($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Data obtenida de manera correcta',
                'data' =>   $datacorreos
            ]);
    }
    public function consultar_informacion_documento(Request $request)
    {
        $datos =  $request->all();
        $data = $this->ReportesService->consultar_informacion_documento($datos);

        return response()->json([
            'success' => true,
            'mensaje' => 'Data obtenida de manera correcta',
            'data' =>   $data
        ]);
    }
}
