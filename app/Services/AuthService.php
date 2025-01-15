<?php

namespace App\Services;

class AuthService
{
    private $httpService;
    private $sistema;
    private $user_basic;
    private $pwd_basic;
    private $url_login;
    private $url_logout;
    private $url_validate_jwt;
    private $url_check_intranet_url;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
        $this->sistema = env('SISTEMA_MSB');
        $this->user_basic = env('USER_BASIC_AUTH');
        $this->pwd_basic = env('PWD_BASIC_AUTH');
        $this->url_login = env('URL_AUTH_LOGIN_API');
        $this->url_logout = env('URL_AUTH_LOGOUT_API');
        $this->url_validate_jwt = env('URL_VALIDATE_JWT_API');
        $this->url_check_intranet_url = env('URL_CHECK_INTRANET_URL_API');
    }

    public function login(string $username, string $password): array
    {
        $params = [
            'form_params' => [
                'siglas_sistema' => $this->sistema,
                'username' => $username,
                'password' => $password,
                'r' => false
            ],
            'auth' => [
                $this->user_basic,
                $this->pwd_basic,
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_login, $params, null);
    }

    public function logout(string $jwtToken): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        return $this->httpService->sendRequest('post', $this->url_logout, [], $headers);
    }

    public function validateJWT(string $jwtToken): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        return $this->httpService->sendRequest('post', $this->url_validate_jwt, [], $headers);
    }

    public function check_intranet_url(string $jwtToken, string $intranetURL): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        $params = [
            'form_params' => [
                'siglas_sistema' => $this->sistema,
                'intranetURL' => $intranetURL,
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_check_intranet_url, $params, $headers);
    }
}
