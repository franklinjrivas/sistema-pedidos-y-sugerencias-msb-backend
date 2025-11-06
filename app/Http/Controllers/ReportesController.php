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
        try {

            $datos =  $request->all();
            $listarporfecha = $this->ReportesService->listar_por_fechas($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporfecha
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_registro_por_area(Request $request)
    {
        try {
            $datos =  $request->all();
            $listarporarea = $this->ReportesService->listar_por_area($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporarea
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_registro_por_area_pendientes(Request $request)
    {
        try {
            $datos =  $request->all();
            $listarporarea = $this->ReportesService->lista_registro_por_area_pendientes($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listarporarea
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_registro_por_area_pendientes_resumen(Request $request)
    {
        try {
            $datos =  $request->all();
            $resumenexpedientependientes = $this->ReportesService->lista_registro_por_area_pendientes_resumen($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $resumenexpedientependientes
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_resumen_alertas(Request $request)
    {
        try {
            $datos =  $request->all();
            $listaalertas = $this->ReportesService->lista_resumen_alertas($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $listaalertas
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function buscar_contribuyente(Request $request)
    {
        try {
            $id = $request->id;
            $contribuyente = $this->ReportesService->buscar_contribuyente($id);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $contribuyente
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function buscar_parte_diario(Request $request)
    {
        try {

            $datos =  $request->all();
            $recepcionados = $this->ReportesService->buscar_parte_diario($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo',
                'data' =>   $recepcionados
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function consultar_expediente(Request $request)
    {
        try {
            $datos =  $request->all();
            $expedientes = $this->ReportesService->consultar_expediente($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Expediente Encontrado',
                'data' => $expedientes
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function consultar_data_email(Request $request)
    {
        try {

            $datos =  $request->all();

            $datacorreos = $this->ReportesService->data_correos($datos);
            // if (!isset($datacorreos) || empty($datacorreos)) throw new \Exception('no esta devolviendo informacion el servicio...');

            return response()->json([
                'success' => true,
                'mensaje' => 'Data obtenida de manera correcta',
                'data' =>   $datacorreos
            ]);


        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function buscar_documentos_recepcionados(Request $request)
    {
        try {
            $datos =  $request->all();
            $datacorreos = $this->ReportesService->buscar_documentos_recepcionados($datos);
            // if (!isset($datacorreos) || empty($datacorreos)) throw new \Exception('no esta devolviendo informacion el servicio...');

            return response()->json([
                'success' => true,
                'mensaje' => 'Data obtenida de manera correcta',
                'data' =>   $datacorreos
            ]);


        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function consultar_informacion_documento(Request $request)
    {
        try {

            log_info('$request');
            log_info($request);
            $datos =  $request->all();
            $data = $this->ReportesService->consultar_informacion_documento($datos);
            // if (!isset($datacorreos) || empty($datacorreos)) throw new \Exception('no esta devolviendo informacion el servicio...');

            return response()->json([
                'success' => true,
                'mensaje' => 'Data obtenida de manera correcta',
                'data' =>   $data
            ]);


        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }


}
