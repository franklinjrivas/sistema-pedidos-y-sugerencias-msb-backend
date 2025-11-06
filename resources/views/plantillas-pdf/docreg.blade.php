<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
            font-size: 9px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        .encabezado {
            text-align: center;
            font-weight: bold;
        }
        .seccion {
            background-color: #ddd;
            font-weight: bold;
            padding: 4px;
            margin-top: 10px;
        }
        .sin-borde td {
            border: none;
            padding: 2px 4px;
            text-align: left;
        }
        .titulo { text-align: center;
            /* font-weight: bold;  */
            font-size: 15px; }
        .seccion { margin-top: 10px; }
        .col { display: inline-block; width: 48%; vertical-align: top; }
        .firma { text-align: center; margin-top: 40px; }
        .subrayado { border-bottom: 1px dotted #000; display: inline-block; min-width: 100px; }
        .fila{
            width: 50%;
            vertical-align: top;"
        }
        .imagen{
            margin-top: -20px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 70px;
            width: 180px;
        }

    </style>
</head>
<body>
    {{-- <pre>{{ print_r($data, true) }}</pre> --}}

    <div class="titulo" >
        <img src="{{ public_path('img/logo-msb-5.png') }}" alt="Logo"  class="imagen">
        <div>
            <strong>&nbsp;HISTORIAL DEL DOCUMENTO&nbsp;</strong><br>
            <strong>NRO. DE TRÁMITE: {{$data[0]->CODIGO}} - {{$data[0]->ANO}}<strong>
        </div>
    </div>
    <br></tr>    <br></tr>
    <table class="sin-borde">
        <tr><td><b>CÓDIGO:</b> </td></tr>
        <tr><td><b>NOMBRE O RAZÓN SOCIAL:</b>{{$data[0]->CTRB_DES}}</td></tr>
        <tr><td><b>DOMICILIO FISCAL:</b> {{$data[0]->CTRB_DIRECCION}}</td></tr>
    </table>
    <br>
    <table>
        <thead>
            <tr class="seccion">
                <th>DOCUMENTO</th>
                <th>FECHA</th>
                <th>MOTIVO</th>
                <th>FOLIO</th>
                <th>REMITIDO A</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data[0]->NRO_EXP }} - {{ $data[0]->ANO_EXP }}</td>
                <td>{{ $data[0]->FECHA_SALIDA }}</td>
                <td>{{ $data[0]->MOTIVO_DES }}</td>
                <td>{{ $data[0]->FOLIOS }}</td>
                <td>{{ $data[0]->AREA_RECIBE_DES }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <h3>MOVIMIENTOS DEL DOCUMENTO</h3>
    <table>
        <thead>
            <tr  class="seccion">
                <th>F. EMISIÓN</th>
                <th>F. RECEPCIÓN</th>
                <th>ÁREA REMITENTE</th>
                <th>ÁREA DESTINO</th>
                <th>ACCIÓN</th>
                <th>PASE</th>
                <th>FOLIOS</th>
                <th>D. TRANSC.</th>
                <th>DIF. DÍAS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->FECHA_SALIDA }}</td>
                    <td>{{ $item->FECHA_RECIBE}}</td>
                    <td  style="text-align: left">{{ $item->AREA_SALIDA_DES }}</td>
                    <td  style="text-align: left">{{ $item->AREA_RECIBE_DES}}</td>
                    <td>{{ $item->ACCION }}</td>
                    <td>{{ $item->ITEM }}</td>
                    <td>{{ $item->FOLIOS }}</td>
                    <td>{{ $item->DIAS_TRANSCURRIDOS}}</td>
                    <td>{{ $item->DIFERENCIA_DIAS }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
