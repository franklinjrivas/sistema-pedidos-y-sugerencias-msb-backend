<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipalidad de San Borja</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', Helvetica, Arial, sans-serif;
            background-color: #f5f5f5;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }

        .header,
        .footer {
            background-color: #39a0aa;
            text-align: center;
            color: #fff;
            padding: 20px;
        }

        .header img {
            max-height: 80px;
        }

        .content {
            padding: 30px;
            color: #555;
            font-size: 16px;
            line-height: 1.5;
        }

        .content h2 {
            margin-top: 0;
            font-size: 24px;
            color: #000;
        }

        .btn {
            display: inline-block;
            background: #16236e;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .content {
                padding: 15px;
                font-size: 15px;
            }

            .content h2 {
                font-size: 20px;
            }
        }
        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    <table role="presentation" class="container">
        <tr>
            <td class="header">
                <img src="https://extranet.msb.gob.pe/images/ngestion/llogo-msb.png" alt="Logo Municipalidad San Borja">
            </td>
        </tr>
        <tr>
            <td class="content">
                <h2 class="centrado"><u>{{ $title }}</u></h2>

                <p><strong>Estimado(a):</strong> {{ $destinatario }}</p>
                <p><strong>Domicilio:</strong> {{ $domicilio }}</p>
                <p><strong>Correo:</strong> {{ $correo }}</p>
                <h3><u>Código Generado</u></h3>
                <table style="width:100%; border-collapse:collapse; border:none;">
                    <tr>
                        <td style="border:none; padding:5px;">Nro Registro : <b>{{$nregistro}}</b></td>
                        <td style="border:none; padding:5px;">
                            Documento : <b>{{$tdocumento}}</b></td>
                    </tr>
                    <tr>
                        <td style="border:none; padding:5px;">Fecha : <b>{{$fecha}}</b></td>
                        <td style="border:none; padding:5px;">Número : <b>{{$numero}}</b></td>
                    </tr>
                </table>
                <p><strong>Detalle:</strong> {{ $detalle }}</p>
                <p><strong>Destino:</strong> {{ $arearecibe }}</p>
                <p><strong>Canal:</strong> {{ $canal }}</p>
                <p><strong>"En caso que usted no consigne de manera adecuada la totalidad de la información requerida como mínima, se considerará el reclamo o queja como no puesto."</strong></p>

                <h3><u>Respuesta</u></h3>
                <div>{!! $contenido_email !!}</div>

{{--
                @if (!empty($atte))
                    <p style="margin-top:30px;">Atentamente,</p>
                    <p><strong>{{ $atte }}</strong></p>
                @endif --}}

                @if (!empty($pie_correo))
                    <p style="margin-top:30px; font-size: 12px; color:#999;">
                        Este mensaje puede contener información confidencial protegida por la Ley N° 29733 - Ley de
                        Protección de Datos Personales.<br>
                        Si no es usted el destinatario, por favor notifíquelo al remitente y elimine este mensaje.<br>
                        <b>NOTA IMPORTANTE:</b> Este correo ha sido enviado desde un buzón de correo masivo y agradeceremos no responderlo.
                    </p>
                @endif
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>&copy; {{ now()->year }} Municipalidad de San Borja</p>
                <p>Todos los derechos reservados</p>
                <p>Av. Joaquín de la Madrid 200 - San Borja - Lima</p>
                <p>Teléfono:      </p>
            </td>
        </tr>
    </table>
</body>

</html>
