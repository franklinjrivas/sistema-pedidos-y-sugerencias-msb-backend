<?php

namespace App\Services;

class RecaptchaService
{
    private $httpService;
    private $verify_url;
    private $private_key;

    public function __construct(HttpService $httpService)
    {
        $this->httpService = $httpService;
        $this->verify_url = config('environment.GOOGLE_RECAPTCHA_VERIFY_URL');
        $this->private_key = config('environment.GOOGLE_RECAPTCHA_KEY_PRIVATE');
    }

    public function validateRecaptchaV2($token): bool
    {
        $params = [
            'form_params' => [
                'secret'   => $this->private_key,
                'response' => $token,
            ],
        ];

        $responseData = $this->httpService->sendRequest('post', $this->verify_url, $params, null);

        return $responseData['success'] ?? false;
    }
}
