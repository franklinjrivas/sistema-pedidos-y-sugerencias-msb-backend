<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Cargo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid black; padding: 4px; vertical-align: top; }
        .no-border { border: none !important; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .header-table td { border: none;text-align: center;
        vertical-align: middle; }
        /* .title { font-size: 14px; font-weight: bold; text-align: center; } */
        .titulo { text-align: center;
            /* font-weight: bold;  */
            font-size: 16px; }
        .footer { font-size: 10px; text-align: left; margin-top: 20px; }



        .imagen {
            margin-top: -10px;
            position: absolute;
            top: 10px;
            left: 10px;
            height: 65px;
            width: 170px;
        }

        .fila {
            height:26px;
            vertical-align: middle;
        }
        .recepcion {
            width:50%;
            height:30px;
            vertical-align: middle;
        }
        .items {
            font-size: 14px;
            margin-top:8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    @php
    \Carbon\Carbon::setLocale('es');
@endphp
    {{-- <pre>{{ print_r($data, true) }}</pre> --}}
    <div class="titulo" >
        <img src="{{ public_path('img/logo-msb-5.png') }}" alt="Logo"  class="imagen">
        <div>
            <br>
            <strong>HOJA DE CARGO</strong><br>

        </div>
    </div>
{{--

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <!-- Columna izquierda (20%) -->
          <td style="width: 20%; text-align: center;" rowspan="4">
            <img src="{{ public_path('img/logo-msb-5.png') }}" alt="Logo" class="imagen" style="max-width: 100px;">
          </td>

          <!-- Columna del medio (60%) -->
          <td style="width: 60%; text-align: center;" rowspan="4">
            <strong>HOJA DE CARGO</strong>
          </td>

          <!-- Columna derecha (20%) - Fila 1 -->
          <td style="width: 20%;">Fila 1</td>
        </tr>
        <tr>
          <td style="width: 20%;">Fila 2</td>
        </tr>
        <tr>
          <td style="width: 20%;">Fila 3</td>
        </tr>
        <tr>
          <td style="width: 20%;">Fila 4</td>
        </tr>
      </table>
 --}}


    <br><br><br>
  <table style="margin-top:5px;">
        <tr>
            <td width="15%" class="fila bold">Nro. Registro:</td>
            <td width="18%" class="fila  bold" style="text-align: center;"> {{$data->CODIGO}} - {{$data->ANO}}</td>
            <td  width="30%" style="border-top: none; border-bottom: none;"></td>
            <td width="15%" colspan="2" class="fila  bold">Documento:</td>

            <td width="15%" colspan="3" class="fila" style="text-align: center;" >{{$data->TIPO_DESCRIPCION}}</td>


        </tr>
        <tr>
            <td class="fila  bold">Fecha:</td>
            <td class="fila" style="text-align: center;">  {{$data->FECHA}} {{$data->HORA}}</td>
            <td style="border-top: none; border-bottom: none;"></td>
            <td width="9%"  class="fila  bold">Número:</td>
            <td colspan="2"  class="fila  bold" style="text-align: center;">{{$data->NRO_DOCUMENTO}} - {{$data->ANO_DOCUMENTO}}</td>
            <td class="fila  bold">Folios</td>
            <td class="fila"> {{$data->FOLIOS}} </td>
        </tr>
    </table>

    <p class="items">I. DATOS DEL REGISTRO</p>

   <table>
        <tr>
            <td width="20%" height="40px" style="vertical-align: middle;" class="fila  bold">Motivo del Registro:</td>
            <td style="vertical-align: middle;"> {{$data->MOTIVO_DES}}</td>
        </tr>
        <tr>
            <td class="bold"  class="fila  bold">Destino:</td>
            <td  class="fila">{{$data->AREADESTINO_DES}} - {{$data->CANAL_DES}}</td>
        </tr>
    </table>

     <p class="items">II. DATOS DEL CIUDADANO O ENTIDAD</p>

    <table>
        <tr>

            <td colspan="2"  width="25%"  class="fila  bold"> Nombres o Razón Social</td>
            <td colspan="7"  width="78%"  class="fila "> {{$data->CTRB_COD}} - {{$data->CTRB_DES}} </td>

        </tr>
        <tr>

            <td colspan="2"  width="25%"  class="fila  bold"> Domicilio Fiscal</td>
            <td colspan="7"  width="78%"  class="fila">{{$data->CTRB_DIRECCION}}</td>

        </tr>
        <tr>



            <td width="12%" class="fila  bold">Doc. Identidad</td>
            <td colspan="2" width="29%" class="fila">{{$data->CTRB_DES_TIPO_DOC}} - {{$data->CTRB_DOC}}</td>
            <td width="7%" class="fila  bold"> Correo</td>
            <td width="29%" class="fila">{{$data->NOTIFICA_EMAIL}}</td>
            <td width="8%" class="fila  bold">Teléfono<</td>
            <td width="10%" class="fila">{{$data->CTRB_TEF}}</td>
            <td width="7%" class="fila  bold">Celular</td>
            <td width="10%" class="fila">{{$data->CTRB_CEL}}</td>
        </tr>
    </table>


    <table style="margin-top:10px">
        <tr>
            <td width="15%" class="bold" style="vertical-align: middle;">Observaciones</td>
            <td  style="margin-top:10px; height:440px "> {{$data->OBSERVACIONES}}</td>
        </tr>
    </table>

    <table style="margin-top:10px; text-align:center; width:30%; margin-left:auto; margin-right:auto;">
        <tr>
            <td class="recepcion">Recepción</td>
            <td class="recepcion"></td>
        </tr>
        <tr>
            <td colspan="2" style="border: none;" >{{$data->USUARIO}}</td>

        </tr>
    </table>

    <p style="text-align:right; margin-top:15px;">
        San Borja, {{ \Carbon\Carbon::createFromFormat('d/m/Y', $data->FECHA)->translatedFormat('j \d\e F \d\e Y') }}
    </p>

    <div class="footer">
        _______________________________________________________________________________________________________________________________<br>
        Telf. 612-5555<br>
        www.munisanborja.gob.pe
    </div>

</body>
</html>
