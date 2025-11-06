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
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .titulo-header {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .imagen {
            margin-top: -10px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 60px;
            width: 140px;
        }

        .clear {
            clear: both;
        }

        .no-border td {
            border: none !important;
        }
        .negritas{
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <header>
        <img src="{{ public_path('img/logo-msb-5.png') }}" class="imagen">
        <div class="titulo-header">
            REPORTE DE DOCUMENTOS PENDIENTES <br>
            @if (!empty($area))
                {{-- <div style="page-break-before: always;"></div> --}}
                <div>
                    {{ $area }}<br>
                </div>
            @endif
            INGRESO DEL: {{ $desde }} AL {{ $hasta }} <br>
            @if (!empty($canal))
                <div>
                    DE {{ $canal }}<br>
                </div>
            @else
                <div>
                    TODOS LOS CANALES<br>
                </div>
            @endif
        </div>
        <div class="clear"></div>
    </header>

    {{-- FOOTER --}}
    <footer>
        <table border="0" style="border-collapse: collapse;">
            <tr>
                <td style="width: 40%; text-align:left; border: none;">www.munisanborja.gob.pe</td>
                <td style="width: 20%; text-align:center; border: none;">
                    Página <span class="pagenum"></span> de <span class="total-pages"></span>
                </td>
                <td style="width: 40%; text-align:right ; border: none;">
                    Generado el {{ \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s') }}
                </td>
            </tr>
        </table>
    </footer>

    {{-- <pre>{{ print_r($desde, true) }}</pre> --}}
    <table>
        <thead>
            <tr class="seccion">
                <th style="width: 3%">N°</th>
                <th style="width: 6%">TRÁMITE</th>
                <th style="width: 11%">DOCUMENTO</th>
                <th style="width: 7%">INGRESO</th>
                <th style="width: 7%">ÚLTIMO PASE</th>
                <th style="width: 28%">ADMINISTRADO</th>
                <th style="width: 29%">MOTIVO</th>
                <th style="width: 7%">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $contador = 1;
            @endphp
            @foreach ($data as $index => $item)
                @if ($item->SITUAC_ACTUAL === 'PENDIENTE')
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>{{ $item->NRO_TRAMITE }} {{ $item->ANO_TRAMITE }} </td>
                        <td>{{ $item->TIPO_DOC }}-{{ $item->NRO_DOC }}-{{ $item->ANO_DOC }}</td>
                        <td>{{ $item->FECHA_TRAMITE }}</td>
                        <td>{{ $item->FECHA_RECIBE }}</td>
                        <td style=" text-align:left; ">{{ strtoupper($item->CTRB_DES) }}</td>
                        <td style=" text-align:left; ">{{ strtoupper($item->MOTIVO_DES) }}</td>
                        <td>{{ strtoupper($item->SITUAC_ACTUAL) }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="negritas">DOCUMENTOS TOTALES: {{ $contador - 1 }}</div>
</body>

</html>
