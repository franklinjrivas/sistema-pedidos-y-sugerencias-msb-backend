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
            font-size: 8px;
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
            height: 65px;
            width: 170px;
        }

        .icono {
            height: 15px;
            width: 27px;
        }

        .clear {
            clear: both;
        }

        .no-border td {
            border: none !important;
        }

        .negritas {
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <header>
        <img src="{{ public_path('img/logo-msb-5.png') }}" class="imagen">
        <div class="titulo-header">
            <br> ALERTAS DE PEDIDOS Y RECLAMACIONES <br>
            {{ $area }} <br>
            FECHA DEL: {{ $desde }} AL {{ $hasta }} <br>

        </div>

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
                <th style="width: 10%">DOCUMENTO</th>
                <th style="width: 5%">INGRESO</th>
                <th style="width: 22%">ADMINISTRADO</th>
                <th style="width: 6%">CANAL</th>
                <th style="width: 6%">TIEMPO DE ATENCIÓN</th>
                <th style="width: 6%">PLAZO POR VENCER</th>
                <th style="width: 5%">SEMAFORO</th>
                <th style="width: 8%">ESTADO</th>
                <th style="width: 23%">AREA</th>
            </tr>
        </thead>
        <tbody>
            {{-- @php
                $contador = 1;
            @endphp --}}
            @foreach ($data as $index => $item)
                {{-- @if ($item->SITUAC_ACTUAL === 'PENDIENTE') --}}
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->TIPO_DOC }} {{ $item->NRO_DOC }}-{{ $item->ANO_DOC }}</td>
                    <td>{{ $item->FECHA_TRAMITE }}</td>
                    <td style=" text-align:left;">{{ strtoupper($item->CTRB_DES) }}</td>
                    <td>{{ $item->CANAL }}</td>
                    <td>{{ $item->TIEMPO_RESPUESTA }}</td>
                    <td>{{ $item->PLAZO }}</td>
                    <td>

                        @switch($item->ALERTA)
                            @case('AMARILLO')
                                <img src="{{ public_path('img/semaforo_amarillo.jpg') }}" class="icono">
                            @break

                            @case('VERDE')
                                <img src="{{ public_path('img/semaforo_verde.jpg') }}" class="icono">
                            @break

                            @case('ROJO')
                                <img src="{{ public_path('img/semaforo_rojo.jpg') }}" class="icono">
                            @break
                        @endswitch
                    </td>
                    <td>
                        @switch($item->ALERTA)
                            @case('AMARILLO')
                                POR VENCER
                            @break

                            @case('VERDE')
                                EN TRAMITE
                            @break

                            @case('ROJO')
                                VENCIDO
                            @break
                        @endswitch
                    </td>
                    <td style=" text-align:left;">{{ strtoupper($item->AREA_RECIBE_DES) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="negritas">DOCUMENTOS TOTALES: {{  count($data) }}</div>
</body>

</html>
