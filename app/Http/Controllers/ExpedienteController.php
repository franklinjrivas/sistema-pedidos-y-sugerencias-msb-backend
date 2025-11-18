<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\EspedienteService;

class ExpedienteController extends Controller
{
    private $EspedienteService;
    private $authService;

    public function __construct(
        EspedienteService $EspedienteService,
        AuthService $authService
    )
    {
        $this->EspedienteService = $EspedienteService;
        $this->authService = $authService;
    }
    public function grabar_expediente(Request $request)
    {
        $datos =  $request->all();
        $listarmotivos = $this->EspedienteService->grabar_expediente($datos);

        return response()->json([
            'success' => true,
            'mensaje' => 'Datos registros con éxito',
            'data' =>   $listarmotivos
        ]);
    }
    public function botones_expediente(Request $request)
    {
        $user = $request->JWT_username;
        // $user = $this->authService->user_magic_ad_match($JWT_token);

        $datos =  $request->all();

        if ($datos['pase'] === 2) {
            $listarmotivos = $this->EspedienteService->confirmar_expediente($user, $datos);
        } elseif ($datos['pase'] === 1) {
            $listarmotivos = $this->EspedienteService->extornar_expediente($datos);
        }
        elseif ($datos['pase'] === 3) {
            $listarmotivos = $this->EspedienteService->anula_expediente($datos);
        }
        return response()->json([
            'success' => true,
            'mensaje' => 'Datos confirmados con éxito',
            'data' =>   $listarmotivos
        ]);
    }
}
