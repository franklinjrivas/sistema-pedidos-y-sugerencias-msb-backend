<?php

namespace App\Services;

use App\Mail\RespuestaCiudadano;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\SendCode2FA;

class EmailService
{
    protected string $sendMailEndpoint;

    public function __construct()
    {
        $this->sendMailEndpoint = config('environment.URL_SEND_MAIL_INTRANET');
    }

    /**
     * Envía un correo electrónico con el código de verificación para el acceso al Magic.
     *
     * @param array $user
     * @param int $code
     * @return array
     */
    public function send_respuesta_ciudadano(array $info): array
    {
        try {
            $data = $info['informacion'];
            $persona = $data['CTRB_DES'];
            $respuesta = $info['respuesta'];
            $area = $data['AREAORIGEN_DES'];
            $mail = $info['informacion']['NOTIFICA_EMAIL'];
            $anio = $data['ANO'];
            $codigo = $data['CODIGO'];
            $pase = $data['ITEM'];
            $usuario = $info['informacion']['USUARIO'];

            $email = new RespuestaCiudadano($persona, $respuesta, $area, $info);

            $cuerpoCorreo = $email->render();

            $send = $this->send_mail($mail, 'Respuesta a su Pedido', $cuerpoCorreo);

            if (!$send) throw new \Exception('No se pudo enviar el correo');

            if (!$send['estado']) throw new \Exception($send['mensaje']);
            if ($send['estado']){
                $enviado = DB::select(
                    'exec piap_qj_tramite_entrada_email_grabar ?,?,?,?,?',
                    [$anio, $codigo, $pase, $respuesta, $usuario]
                );
            }

            return [
                'success' => true,
                'mensaje' => 'Correo electrónico enviado correctamente',
            ];
        } catch (\Throwable $e) {
            Log::info('EmailService->send_respuesta_ciudadano');
            Log::info($e);
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Envía un correo electrónico por el Servicio de la Intranet MSB
     *
     * @param string $correo
     * @param string $asunto
     * @param string $cuerpo
     * @return array
     */
    private function send_mail(string $correo, string $asunto, string $cuerpo): array
    {
        try {
            $response = Http::timeout(15)
                ->withOptions(['verify' => false]) // <- ignora SSL
                ->post($this->sendMailEndpoint, [
                    'tipo_doc' => '01',
                    'documento' => '12345678',
                    'correo' => $correo,
                    'asunto' => $asunto,
                    'cuerpo' => $cuerpo,
                    'exclusion' => 1
                ]);

            $data = $response->json();

            if (!$response->successful()) {
                throw new \Exception($data);
            }

            return $data;
        } catch (\Throwable $e) {
            Log::info('EmailService->send_mail');
            Log::info($e);
            throw new \Exception('Error al enviar el correo electrónico');
        }
    }
}
