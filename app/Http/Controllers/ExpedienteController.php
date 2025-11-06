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
    public function grabar_expediente(Request $request) {
        try {


            // $JWT_token = $request->JWT_token;
            // $user1 = $this->authService->user_magic_ad_match($JWT_token);
            // $user= $user1['data']['username_magic'];
            $usuario =  $request->JWT_token;

            $datos =  $request->all();


            $listarmotivos = $this->EspedienteService->grabar_expediente($datos, $usuario);
            // $listarmotivos =[];

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
    public function botones_expediente(Request $request) {
        try {
            $JWT_token = $request->JWT_token;
            $user = $this->authService->user_magic_ad_match($JWT_token);

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

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }


}
