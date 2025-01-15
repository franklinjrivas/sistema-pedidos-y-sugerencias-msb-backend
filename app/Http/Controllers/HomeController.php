<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\HomeController\MenuRequest;
use App\Http\Requests\HomeController\ChangeRolRequest;

use App\Services\HomeService;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function roles(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;

            $roles = $this->homeService->roles($JWT_token);

            if (!isset($roles) || empty($roles)) throw new \Exception('El servicio de Autenticación está presentando problemas...');

            if (!$roles['success']) throw new \Exception($roles['mensaje']);

            return response()->json($roles);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function menu(MenuRequest $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $id_rol = $request->id_rol;

            $menu = $this->homeService->menu($JWT_token, $id_rol);

            if (!isset($menu) || empty($menu)) throw new \Exception('El servicio de Autenticación está presentando problemas...');

            if (!$menu['success']) throw new \Exception($menu['mensaje']);

            return response()->json($menu);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function change_rol(ChangeRolRequest $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $id_rol_change = $request->id_rol_change;

            $this->homeService->change_rol($JWT_token, $id_rol_change);

            return response()->json([
                'success' => true,
                'mensaje' => 'Rol cambiado correctamente',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
