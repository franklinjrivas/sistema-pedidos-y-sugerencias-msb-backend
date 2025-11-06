<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class SendEmailController extends Controller
{
    private EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function send_mail(Request $request)
    {
        try {
            $login = $this->emailService->send_respuesta_ciudadano($request->all());

            if (!isset($login) || empty($login)) throw new \Exception('El servicio de Autenticación está presentando problemas...');

            if (!$login['success']) throw new \Exception($login['mensaje']);

            return response()->json($login);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

}
