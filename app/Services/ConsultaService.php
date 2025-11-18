<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsultaService
{

    public function list_personas()
    {
        $item_x_page = $item_x_page ?? 10;

        $tipo = DB::select(
            'exec piap_qj_tipodocpresentado_lista2',
            []
        );

        $canal = DB::select(
            'exec piap_qj_canales_lista',
            []
        );

        $sede = DB::select(
            'exec piap_qj_sedes ?',
            [0]
        );

        $area = DB::select(
            'exec piap_qj_areas_lista ?,?',
            [0,1]
        );
        return [
            'success'=> true,
            'mensaje'=> '',
            'listtipo'=> $tipo,
            'listcanal'=> $canal,
            'listsede'=> $sede,
            'listaarea'=> $area
        ];
    }
    public function list_recepcion(?string $fecha, ?string $idtipo, ?int $idcanal, ?int $idsede)
    {
        $data = DB::select(
            'exec piap_qj_mesaparte_tramite_lista ?,?,?,?',
            [$fecha, $idtipo, $idcanal, $idsede]
        );
        return [
            'success'=> true,
            'mensaje'=> '',
            'listtipo'=> $data
        ];
    }
}
