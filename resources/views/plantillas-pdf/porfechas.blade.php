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
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .titulo-header {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
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

    </style>
</head>
<body>

    {{-- HEADER --}}
    <header>
        <img src="{{ public_path('img/logo-msb-5.png') }}" class="imagen">
        <div class="titulo-header">
            REPORTE DE DOCUMENTOS TRAMITADOS<br>
            del {{$desde}} al {{$hasta}}
        </div>
        <div class="clear"></div>
    </header>

    {{-- FOOTER --}}
    <footer>
        <table border="0" style="border-collapse: collapse;">
            <tr>
                <td style="width: 45%; text-align:left; border: none;">www.munisanborja.gob.pe</td>
                <td style="width: 10%; text-align:center; border: none;">
                    Página <span class="pagenum"></span> de <span class="total-pages"></span>
                </td>
                <td style="width: 45%; text-align:right ; border: none;">
                    Generado el {{ \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s') }}
                </td>
            </tr>
        </table>
    </footer>

    {{-- TABLA DE DATOS --}}
    <table>
        <thead>
            <tr class="seccion">
                <th>N°</th>
                <th>FECHA</th>
                <th>TRÁMITE</th>
                <th>DOCUMENTO</th>
                <th>ADMINISTRADO</th>
                <th>MOTIVO</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->FECHA }}</td>
                    <td>{{ $item->ANO }} - {{ str_pad($item->CODIGO, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $item->TIPO_DES }} - {{ str_pad($item->CODIGO_DOCUMENTO, 6, '0', STR_PAD_LEFT) }} - {{ $item->ANO_DOCUMENTO }}</td>
                    <td>{{ strtoupper($item->CTRB_DES) }}</td>
                    <td>{{ strtoupper($item->MOTIVO_DES) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div>DOCUMENTOS TOTALES: {{ count($data) }}</div>




</body>
</html>
