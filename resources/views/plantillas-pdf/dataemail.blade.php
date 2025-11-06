<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de documentos</title>
    <style>
        @page {
            margin: 120px 50px 80px 50px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            text-align: center;
            font-size: 10px;
            color: #888;
        }

        .pagenum:before {
            content: counter(page);
        }

        .total-pages:before {
            content: counter(pages);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 30px
        }

        th, td {
            border: 1px solid #ffffff;
            padding: 5px;
            font-size: 13px;
        }

        .titulo-header {
            font-size: 20px;
            font-weight: bold;
            margin-top: 50px;
        }

        .imagen{
            margin-top: -20px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 70px;
            width: 180px;
        }

        .clear {
            clear: both;
        }

        .cabecera {
            width: 20%;
            text-align: right;
        }
        .detalle {
            width: 80%;
            text-align: justify;
            font-weight: bold;
        }

    </style>
</head>
<body>

    {{-- HEADER --}}
    <header>
        <img src="{{ public_path('img/logo-msb-5.png') }}" class="imagen">
        <div class="titulo-header">
            {{$data->TIPO_DESCRIPCION}} - {{$data->NRO_DOCUMENTO}} - {{$data->ANO}} <br>
            del {{$data->FECHA_TRAMITE}}
        </div>
        <div class="clear"></div>
    </header>

    {{-- FOOTER --}}
    <footer>
        <table border="0" style="border-collapse: collapse;">
            <tr>
                <td style="width: 45%; text-align:left; border: none;">www.munisanborja.gob.pe</td>
                {{-- <td style="width: 10%; text-align:center; border: none;">
                    Página <span class="pagenum"></span> de <span class="total-pages"></span>
                </td> --}}
                <td style="width: 45%; text-align:right ; border: none;">
                    Generado el {{ \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s') }}
                </td>
            </tr>
        </table>
    </footer>

    {{-- TABLA DE DATOS --}}
    <table>
        <tbody>

                <tr>
                    <td class="cabecera">Administrado:</td>
                    <td class="detalle">{{ $data->CTRB_DES }}</td>

                </tr>
                <tr>
                    <td  class="cabecera">E-Mail:</td>
                    <td class="detalle">{{ strtoupper($data->NOTIFICA_EMAIL) }}</td>

                </tr>
                <tr>
                    <td  class="cabecera">Asunto:</td>
                    <td class="detalle">{{ $data->MOTIVO_DES }}</td>

                </tr>
                <tr>
                    <td class="cabecera">Queja o Sugerencia:</td>
                    <td class="detalle">{{ $data->DETALLE_QUEJA }}</td>

                </tr>
                <tr>
                    <td class="cabecera">Atención:</td>
                    <td class="detalle">{{ str_replace("\xc2\xa0", ' ', html_entity_decode(strip_tags($data->EMAIL_ATENCION))) }}</td>
                </tr>
                <tr>
                    <td class="cabecera">Fecha de Atención:</td>
                    <td class="detalle">{{ $data->FECHA_EMAIL_ATENCION }}</td>

                </tr>

        </tbody>
    </table>





</body>
</html>
