<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Services\MantenimientoService;

class MantenimientoController extends Controller
{
    private $MantenimientoService;
    private $authService;

    public function __construct(
        MantenimientoService $MantenimientoService,
        AuthService $authService
    )
    {
        $this->MantenimientoService = $MantenimientoService;
        $this->authService = $authService;
    }

    public function listar_tipo_mantenimiento(Request $request)
    {
        $datos =  $request->all();
        $listatipos = $this->MantenimientoService->listar_tipo_mantenimiento();

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo',
            'data' =>   $listatipos
        ]);
    }
    public function listar_areas_insertar_motivos(Request $request)
    {
        $listatipos = $this->MantenimientoService->listar_areas_insertar_motivos();

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo',
            'data' =>   $listatipos
        ]);
    }
    public function listar_tipo_detalla_mantenimiento(Request $request)
    {
        $datos =  $request->all();
        $listatipos = $this->MantenimientoService->listar_tipo_detalla_mantenimiento( $datos);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo',
            'data' =>   $listatipos
        ]);
    }
    public function listar_data_mantenimiento(Request $request)
    {
        $datos =  $request->all();
        $listadata = $this->MantenimientoService->listar_data_mantenimiento($datos);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo',
            'data' =>   $listadata
        ]);
    }
    public function eliminar_mantenimiento(Request $request)
    {
        $usuario = $request->JWT_username;
        $datos =  $request->all();
        $eliminadata = $this->MantenimientoService->eliminar_mantenimiento($datos, $usuario);

        return response()->json([
            'success' => true,
            'mensaje' => 'Eliminado correctamente',
            'data' =>   $eliminadata
        ]);
    }
    public function guardar_mantenimiento(Request $request)
    {
        $datos =  $request->all();
        $eliminadata = $this->MantenimientoService->guardar_mantenimiento($datos);

        return response()->json([
            'success' => true,
            'mensaje' => 'Eliminado correctamente',
            'data' =>   $eliminadata
        ]);
    }
}
