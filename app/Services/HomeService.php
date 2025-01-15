<?php

namespace App\Services;

class HomeService
{
    private $httpService;
    private $sistema;
    private $url_roles;
    private $url_menu;
    private $url_change_rol;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
        $this->sistema = env('SISTEMA_MSB');
        $this->url_roles = env('URL_ROLES_USER_X_SISTEMA_API');
        $this->url_menu = env('URL_ROLES_GENERATE_MENU_API');
        $this->url_change_rol = env('URL_CHANGE_SELECTED_ROL_API');
    }

    public function roles(string $jwtToken): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        $params = [
            'form_params' => [
                'siglas_sistema' => $this->sistema,
            ]
        ];

        return $this->httpService->sendRequest('post', $this->url_roles, $params, $headers);
    }

    public function menu(string $jwtToken, int $id_rol): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        $params = [
            'form_params' => [
                'siglas_sistema' => $this->sistema,
                'id_rol' => $id_rol
            ]
        ];

        return $this->httpService->sendRequest('post', $this->url_menu, $params, $headers);
    }

    public function change_rol(string $jwtToken, int $id_rol_change): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        $params = [
            'form_params' => [
                'siglas_sistema' => $this->sistema,
                'id_rol_change' => $id_rol_change
            ]
        ];

        return $this->httpService->sendRequest('post', $this->url_change_rol, $params, $headers);
    }
}
