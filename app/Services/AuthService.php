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
    private $url_user_magic_ad_match;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
        $this->sistema = config('environment.SISTEMA_MSB');
        $this->user_basic = config('environment.USER_BASIC_AUTH');
        $this->pwd_basic = config('environment.PWD_BASIC_AUTH');
        $this->url_login = config('environment.URL_AUTH_LOGIN_API');
        $this->url_logout = config('environment.URL_AUTH_LOGOUT_API');
        $this->url_validate_jwt = config('environment.URL_VALIDATE_JWT_API');
        $this->url_check_intranet_url = config('environment.URL_CHECK_INTRANET_URL_API');
        $this->url_user_magic_ad_match = config('environment.URL_USER_MAGIC_AD_MATCH_API');
    }

    public function login(string $username, string $password): array
    {
        $params = [
            'json' => [
                'siglas_sistema' => $this->sistema,
                'username' => $username,
                'password' => $password,
                'r' => false,
                'audit' => getAudit(),
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

        $params = [
            'json' => [
                'siglas_sistema' => $this->sistema,
                'audit' => getAudit(),
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_logout, $params, $headers);
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
            'json' => [
                'siglas_sistema' => $this->sistema,
                'intranetURL' => $intranetURL,
            ],
        ];

        return $this->httpService->sendRequest('post', $this->url_check_intranet_url, $params, $headers);
    }

    public function user_magic_ad_match(string $jwtToken): array
    {
        $headers = $this->httpService->bearer_header($jwtToken);

        return $this->httpService->sendRequest('post', $this->url_user_magic_ad_match, [], $headers);
    }
}
