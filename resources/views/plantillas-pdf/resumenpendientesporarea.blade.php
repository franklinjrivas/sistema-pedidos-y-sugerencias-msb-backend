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
            margin-top: -5px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 65px;
            width: 160px;
        }

        .clear {
            clear: both;
        }

        .no-border td {
            border: none !important;
        }

        .negritas {
            font-weight: bold;
            text-align: right;
            font-size: 18px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <header>
        <img src="{{ public_path('img/logo-msb-5.png') }}" class="imagen">
        <div class="titulo-header">
            REPORTE RESUMEN DE DOCUMENTOS <br>PENDIENTES POR AREA <br>
            INGRESO DEL: {{ $desde }} AL {{ $hasta }} <br>
            @switch($motivo)
                @case('1')
                    <div>TODOS LOS MOTIVOS</div>
                @break

                @case('2')
                    <div>DE PLATAFORMA DE ATENCIÓN</div>
                @break

                @case('3')
                    <div>NO INCLUYE PLATAFORMA DE ATENCIÓN</div>
                @break
            @endswitch

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
    @php
        $totalGeneral = 0;
    @endphp
    {{-- <pre>{{ print_r($desde, true) }}</pre> --}}
    <table>
        <thead>
            <tr class="seccion">
                <th style="width: 3%">N°</th>
                <th style="width: 89%">ÁREA</th>
                <th style="width: 8%">CANTIDAD</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($data as $index => $item)
                @php
                    $totalGeneral += $item->CANTIDAD;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style=" text-align:left; ">{{ strtoupper($item->AREA_RECIBE_DES) }}</td>
                    <td>{{ $item->CANTIDAD }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <div class="negritas">DOCUMENTOS TOTALES: {{ $totalGeneral }}</div>
</body>

</html>
