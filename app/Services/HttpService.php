<?php

namespace App\Services;

use GuzzleHttp\Client;

class HttpService
{
    public function bearer_header(string $jwtToken): array
    {
        return [
            'Authorization' => 'BEARER '.$jwtToken
        ];
    }

    private function clienteHttp(?array $headers): Client
    {
        $options['verify'] = false;

        if (isset($headers)) {
            $options['headers'] = $headers;
        }

        return new Client($options);
    }

    public function sendRequest(string $method, string $url, array $params, ?array $headers): array
    {
        $client = $this->clienteHttp($headers);

        try {
            switch (strtolower($method)) {
                case 'post':
                    $response = $client->post($url, $params);
                    break;
                case 'get':
                    $response = $client->get($url, $params);
                    break;
                default:
                    throw new \InvalidArgumentException("Método HTTP no soportado: $method");
            }

            $responseData = json_decode($response->getBody(), true);
            return $responseData;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            log_info('Error en el servicio: '.$url);
            log_info($e);
            return [
                'success' => false,
                'mensaje' => 'Ocurrió un error inesperado durante el proceso de Autenticación',
            ];
        }
    }
}
