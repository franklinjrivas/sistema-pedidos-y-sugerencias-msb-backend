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
        $totalPendiente = 0;
        $totalAtencion = 0;
        $totalFinalizado = 0;
        $totalGeneral = 0;
    @endphp

    <table>
        <thead>
            <tr class="seccion">
                <th style="width: 3%">N°</th>
                <th style="width: 77%">AREA</th>
                <th style="width: 5%">PENDIENTE</th>
                <th style="width: 5%">ATENCION</th>
                <th style="width: 5%">FINALIZADO</th>
                <th style="width: 5%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                @php
                    $totalPendiente += $item->PENDIENTE;
                    $totalAtencion += $item->ATENDIDO;
                    $totalFinalizado += $item->FINALIZADO;
                    $totalGeneral += $item->CANTIDAD;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td style=" text-align:left; ">{{ $item->AREA_RECIBE_DES }}</td>
                    <td>{{ $item->PENDIENTE }}</td>
                    <td>{{ $item->ATENDIDO }}</td>
                    <td>{{ strtoupper($item->FINALIZADO) }}</td>
                    <td>{{ $item->CANTIDAD }}</td>
                </tr>
            @endforeach

            <tr class="no-border">
                <td colspan="6"></td>
            </tr>
            <tr class="no-border">
                <td colspan="2"><strong>DOCUMENTOS TOTALES:</strong></td>
                <td>{{ $totalPendiente }}</td>
                <td>{{ $totalAtencion }}</td>
                <td>{{ $totalFinalizado }}</td>
                <td>{{ $totalGeneral }}</td>
            </tr>
        </tbody>
    </table>





</body>

</html>
