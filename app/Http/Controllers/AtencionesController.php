<?php

namespace App\Http\Controllers;

use App\Services\AtencionesService;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AtencionesController extends Controller
{
    private $AtencionesService;
    private $authService;

    public function __construct(
        AtencionesService $AtencionesService,
        AuthService $authService
    ) {
        $this->AtencionesService = $AtencionesService;
        $this->authService = $authService;
    }

    public function listaexpedientespendientes(Request $request)
    {
        try {
            $datos =  $request->all();

            $listarmotivos = $this->AtencionesService->listar_expedientes_pendientes($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Datos registros con éxito',
                'data' =>   $listarmotivos
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function detalleexpedientependiente(Request $request)
    {
        try {
            $datos =  $request->all();
            $listarmotivos = $this->AtencionesService->detalle_expediente_pendiente($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Datos registros con éxito',
                'data' =>   $listarmotivos
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function buscar_id(Request $request)
    {
        try {
            $data = $this->AtencionesService->buscar_id_area_p();
            return response()->json([
                'success' => true,
                'mensaje' => 'Id recibido con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_filtros_busqueda(Request $request)
    {
        try {
            $datos =  $request->all();
            $datos = $this->AtencionesService->lista_filtros_busqueda($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Data recibida con éxito',
                'data' =>   $datos
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_motivos_reportes(Request $request)
    {
        try {
            $datos =  $request->all();
            $data = $this->AtencionesService->lista_motivos_reportes($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Data recibida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function recepcionarexpediente(Request $request)
    {
        try {
            $usuario = $request->JWT_username;
            $datos =  implode('', $request->data);

            $recepcioon = $this->AtencionesService->recepcionar_expediente($datos, $usuario);


            return response()->json([
                'success' => true,
                'mensaje' => 'Datos registros con éxito',
                'data' =>   $recepcioon
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listaexpedientesrecepcionados(Request $request)
    {
        try {
            $datos =  $request->all();
            $recepcionados = $this->AtencionesService->listar_expedientes_recepcionados($datos);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de expedientes obtenido con éxito',
                'data' =>   $recepcionados
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listarderivacion(Request $request)
    {
        try {
            $data =  $request->all();
            $recepcionados = $this->AtencionesService->listar_derivacion($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de expedientes obtenido con éxito',
                'data' =>   $recepcionados
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_expedientes_derivados(Request $request)
    {
        try {
            $data =  $request->all();
            $derivados = $this->AtencionesService->lista_expedientes_derivados($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de expedientes obtenido con éxito',
                'data' =>   $derivados
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function buscar_expedientes(Request $request)
    {
        try {
            $data =  $request->all();
            $derivados = $this->AtencionesService->buscar_expedientes($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de expedientes obtenido con éxito',
                'data' =>   $derivados
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function lista_tipos_busqueda(Request $request)
    {
        try {

            $data =  $request->all();
            $tipos = $this->AtencionesService->lista_tipos_busqueda($data);
            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de expedientes obtenido con éxito',
                'data' =>   $tipos
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }




    public function listarareas(Request $request)
    {
        try {

            // $JWT_token = $request->JWT_token;
            // $user = $this->authService->user_magic_ad_match($JWT_token);
            $datos =  $request->all();
            $areas = $this->AtencionesService->listar_areas($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de areas obtenido con éxito',
                'data' =>   $areas
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function extornarexpediente(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $usuario = $this->authService->user_magic_ad_match($JWT_token);
            $datos =  $request->all();
            $extorno = $this->AtencionesService->extornar_expediente($datos, $usuario);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado de areas obtenido con éxito',
                'data' =>   $extorno
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function cargardetalledocumentorecepcionados(Request $request)
    {
        try {
            $datos =  $request->all();
            $data = $this->AtencionesService->cargar_detalle_documento($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function grabardocumentorecepcionados(Request $request)
    {
        try {
            $datos =  $request->all();
            $data = $this->AtencionesService->grabar_documento($datos);

            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function mostrardetallenotificacion(Request $request)
    {
        try {
            $data = $this->AtencionesService->notificacion_detalle($request['id']);
            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listanotificacion(Request $request)
    {
        try {
            $data = $this->AtencionesService->lista_notificacion($request['anio'],$request['numero'],$request['pase'],$request['area'],$request['tipo']);
            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function eliminarnotificacion(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $usuario = $this->authService->user_magic_ad_match($JWT_token);
            $data = $this->AtencionesService->elimina_notificacion($request['id'],$usuario );
            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
                'data' =>   $data
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function cerrar_expediente(Request $request)
    {
        try {

            $datos =  $request->all();
            $data = $this->AtencionesService->cerrar_expediente($datos );

            return response()->json([
                'success' => true,
                'mensaje' => 'Información obtenida con éxito',
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
