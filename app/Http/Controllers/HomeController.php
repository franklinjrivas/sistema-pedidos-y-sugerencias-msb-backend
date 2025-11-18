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
        $JWT_token = $request->JWT_token;

        $roles = $this->homeService->roles($JWT_token);

        if (!isset($roles) || empty($roles)) validationError('El servicio de Autenticación está presentando problemas...');

        if (!$roles['success']) validationError($roles['mensaje']);

        return response()->json($roles);
    }

    public function menu(MenuRequest $request)
    {
        $JWT_token = $request->JWT_token;
        $id_rol = $request->id_rol;

        $menu = $this->homeService->menu($JWT_token, $id_rol);

        if (!isset($menu) || empty($menu)) validationError('El servicio de Autenticación está presentando problemas...');

        if (!$menu['success']) validationError($menu['mensaje']);

        return response()->json($menu);
    }

    public function change_rol(ChangeRolRequest $request)
    {
        $JWT_token = $request->JWT_token;
        $id_rol_change = $request->id_rol_change;

        $this->homeService->change_rol($JWT_token, $id_rol_change);

        return response()->json([
            'success' => true,
            'mensaje' => 'Rol cambiado correctamente',
        ]);
    }
}
