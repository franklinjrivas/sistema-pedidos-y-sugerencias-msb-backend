<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class RespuestaCiudadano extends Mailable
{
    use Queueable, SerializesModels;
    private string $mail_from;
    private string $mail_from_name;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $persona, public string $respuesta, public string $area, public array $info)
    {
        $this->mail_from = '';
        $this->mail_from_name = '';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->mail_from, $this->mail_from_name),
            subject: 'Respuesta para el Ciudadano',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.layout',
            with: [
                'title' => 'RESPUESTA DE TU '. $this->info['informacion']['TIPO_DESCRIPCION'],
                'destinatario' => $this->persona,
                'contenido_email' => $this->respuesta,
                'domicilio' => $this->info['informacion']['DIRECCION_NOTIFICA'],
                'correo' => $this->info['informacion']['NOTIFICA_EMAIL'],
                'nregistro' => $this->info['informacion']['CODIGO'].'-'. $this->info['informacion']['ANO'],
                'tdocumento' => $this->info['informacion']['TIPO_DESCRIPCION'],
                'fecha' => $this->info['informacion']['FECHA_SALIDA'].' '.$this->info['informacion']['HORA_SALIDA'],
                'numero' => $this->info['informacion']['NRO_DOCUMENTO'].' '.$this->info['informacion']['ANO_DOCUMENTO'],
                'arearecibe' => $this->info['informacion']['AREA_RECIBE'],
                'canal' => $this->info['informacion']['CANAL_DES'],
                'detalle' => $this->info['informacion']['DETALLE_QUEJA'],
                'atte' => $this->area,
                'pie_correo' => true
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
