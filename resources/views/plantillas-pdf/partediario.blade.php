<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Hoja de Cargo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
            padding: 4px;
            vertical-align: top;
            font-size: 9px;
        }

        .no-border {
            border: none !important;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .header-table td {
            border: none;
            text-align: center;
            vertical-align: middle;
        }

        .titulo {
            text-align: center;
            font-size: 16px;
            margin-bottom: 28px;
        }

        line-height: 1;

        header {
            position: fixed;
            top: 0px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            line-height: 35px;

        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            font-size: 10px;
            text-align: left;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .imagen {
            margin-top: -10px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 65px;
            width: 170px;
        }

        .fila {
            height: 26px;
            vertical-align: middle;
        }

        .recepcion {
            width: 50%;
            height: 30px;
            vertical-align: middle;
        }

        .items {
            font-size: 14px;
            margin-top: 8px;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .totales {
            margin-top: 20px;
        }

        .table1 {
            width: 90% !important;
            font-size: 12px !important;
            border: none !important;
            border-collapse: collapse;
        }

        .table1 td,.table1 th {
            padding: 4px;
            font-size: 12px !important;
            border: none !important;
        }
    </style>
</head>

<body>
    @php
        \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s');
    @endphp
    {{-- <pre>{{ print_r($data, true) }}</pre> --}}

    <body>
        <header>
            <div class="titulo">
                <img src="{{ public_path('img/logo-msb-5.png') }}" alt="Logo" class="imagen">
                <strong>REPORTE DE DOCUMENTOS RECEPCIONADOS<br>DE FECHA: {{ date('d/m/Y H:i:s') }}</strong><br>
            </div>
        </header>

        <footer>
            Generado el {{ \Carbon\Carbon::now('America/Lima')->format('d/m/Y H:i:s') }}
        </footer>

        <main>
            <table>
                <thead>
                    <tr>
                        <th>TRAM.</th>
                        <th>DOC</th>
                        <th>NUM.</th>
                        <th>NOMBRE O RAZON SOCIAL</th>
                        <th>DOMICILIO FISCAL</th>
                        <th>MOTIVO</th>
                        <th>DESTINO</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sumacanalP = 0;
                        $sumacanalB = 0;
                        $sumacanalT = 0;
                        $sumacanalW = 0;
                        $sumaquejaP = 0;
                        $sumasugerenciaP = 0;
                        $sumaqueja = 0;
                        $sumareclamo = 0;
                        $sumasugerencia = 0;
                        $sumapedido = 0;
                     @endphp
                    @foreach ($data as $doc)
                    @php
                        $sumacanalP = $sumacanalP + ($doc->CANAL == 1?1:0);
                        $sumacanalB = $sumacanalB + ($doc->CANAL == 2?1:0);
                        $sumacanalT = $sumacanalT + ($doc->CANAL == 3?1:0);
                        $sumacanalW = $sumacanalW + ($doc->CANAL == 4?1:0);
                        $sumaquejaP = $sumaquejaP + ($doc->CANAL == 1 && $doc->TIPO == 3?1:0);
                        $sumasugerenciaP = $sumasugerenciaP + ($doc->CANAL == 1 && $doc->TIPO == 4?1:0);
                        $sumaqueja = $sumaqueja + ($doc->TIPO == 3?1:0);
                        $sumareclamo = $sumareclamo + ($doc->TIPO == 5?1:0);
                        $sumasugerencia = $sumasugerencia + ($doc->TIPO == 4?1:0);
                        $sumapedido = $sumapedido + ($doc->TIPO == 7?1:0);
                    @endphp

                        <tr>
                            <td class="center">{{ $doc->CODIGO }}</td>
                            <td class="center">{{ $doc->TIPO_DESCRIPCION }}</td>
                            <td class="center">{{ $doc->NRO_DOCUMENTO }} - {{ $doc->ANO_DOCUMENTO }}</td>
                            <td>{{ $doc->CTRB_DES }}</td>
                            <td>{{ $doc->CTRB_DIRECCION }}</td>
                            <td>{{ $doc->MOTIVO_DES }}</td>
                            <td class="center">{{ $doc->AREADESTINO_ABR }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <table class="totales table1">

                <tr>
                    <td style="width: 25%">Total Quejas - Plataforma de Atención :</td>
                    <td style="width: 5%">{{$sumaquejaP}}</td>
                    <td style="width: 35%"></td>
                    <td style="width: 15%">Total por Plataforma :</td>
                    <td style="width: 5%">{{$sumacanalP}}</td>
                </tr>
                <tr>
                    <td>Total Sugerencias - Plataforma de Atención :</td>
                    <td>{{$sumasugerenciaP}}</td>
                    <td></td>
                    <td>Total por Buzón </td>
                    <td>{{$sumacanalB}}</td>
                </tr>
                <tr>
                    <td>Total Quejas :</td>
                    <td>{{$sumaqueja}}</td>
                    <td></td>
                    <td>Total por Telefonía :</td>
                    <td>{{$sumacanalT}}</td>
                </tr>
                <tr>
                    <td>Total Sugerencias : </td>
                    <td>{{$sumasugerencia}}</td>
                    <td></td>
                    <td>Total por Web :</td>
                    <td>{{$sumacanalW}}</td>
                </tr>
                <tr>
                    <td>Total Reclamaciones :</td>
                    <td>{{$sumareclamo}}</td>
                    <td></td>
                    <td><strong>TOTAL DOCUMENTOS :</strong></td>
                    <td><strong>{{$sumacanalP + $sumacanalB + $sumacanalT + $sumacanalW}}</strong></td>
                </tr>
                <tr>
                    <td>Total Pedidos :</td>
                    <td>{{$sumapedido}}</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td><strong>TOTAL DOCUMENTOS :</strong></td>
                    <td><strong>{{$sumaquejaP + $sumasugerenciaP + $sumaqueja + $sumareclamo + $sumasugerencia + $sumapedido}}</strong></td>
                    <td colspan="3"></td>
                </tr>

            </table>
        </main>
    </body>
</body>

</html>
