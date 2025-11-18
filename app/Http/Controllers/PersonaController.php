<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PersonaService;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    private $PersonaService;
    private $authService;

    public function __construct(
        PersonaService $PersonaService,
        AuthService $authService
    )
    {
        $this->PersonaService = $PersonaService;
        $this->authService = $authService;
    }

    public function listarpersona(Request $request)
    {
        $codigo = $request->codigo ? $request->codigo : null;
        $numerodoctit = $request->numerodoctit ? $request->numerodoctit : null;
        $apepaternotit = $request->apepaternotit ? $request->apepaternotit : null;
        $apematernotit = $request->apematernotit ? $request->apematernotit : null;
        $nombretit = $request->nombretit ? $request->nombretit : null;
        $numerodocon = $request->numerodocon ? $request->numerodocon : null;
        $apepaternocon = $request->apepaternocon ? $request->apepaternocon : null;
        $apematernocon = $request->apematernocon ? $request->apematernocon : null;
        $nombrecon = $request->nombrecon ? $request->nombrecon : null;

        $listarpersona = $this->PersonaService->listar_personas($codigo, $numerodoctit, $apepaternotit,  $apematernotit, $nombretit, $numerodocon, $apepaternocon, $apematernocon, $nombrecon);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo',
            'data' =>   $listarpersona
        ]);
    }

    public function listardocidentidad(Request $request)
    {
        $listardocidentidad = $this->PersonaService->listar_doc_identidad();

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo de Documentos de Identidad',
            'data' =>   $listardocidentidad
        ]);
    }

    public function listamotivos(Request $request)
    {
        $id = $request->idcanal;
        $area = $request->area;

        $listarmotivos = $this->PersonaService->listar_motivos($id, $area);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado motivos',
            'data' =>   $listarmotivos
        ]);
    }
    public function listardepartamentos()
    {
        $listardepartamentos = $this->PersonaService->listar_departamentos();

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo dedepartamentos',
            'data' =>   $listardepartamentos
        ]);
    }
    public function listarprovincias(Request $request)
    {
        $id = $request->id;
        $desc = $request->desc;

        $listarprovincias = $this->PersonaService->listar_provincias($id, $desc);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo  provincia',
            'data' =>   $listarprovincias
        ]);
    }

    public function listardistritos(Request $request)
    {
        $id = $request->id;
        $desc = $request->desc ;
        $listardistritos = $this->PersonaService->listar_distritos($id, $desc);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo distritos',
            'data' =>   $listardistritos
        ]);
    }
    public function listarurbanizaciones()
    {
        $listarurbanizaciones = $this->PersonaService->listar_urbanizaciones();

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo de urbanizaciones',
            'data' =>   $listarurbanizaciones
        ]);
    }


    public function listarvias(Request $request)
    {
        $ubigeo = $request->ubigeo;
        $listarvias = $this->PersonaService->listar_vias($ubigeo);

        return response()->json([
            'success' => true,
            'mensaje' => 'Listado completo de vias',
            'data' =>   $listarvias
        ]);
    }
    public function detallemesaayuda(Request $request)
    {
        $anio = $request->anio;
        $codigo = $request->codigo;
        $tipo = $request->tipo;
        $datadocumento = $this->PersonaService->detalle_documento($anio,$codigo,$tipo );

        return response()->json([
            'success' => true,
            'mensaje' => 'Datos del documento',
            'data' =>   $datadocumento
        ]);
    }
    public function listarinteriores(Request $request)
    {
        $listainteriores = $this->PersonaService->listar_interiores();

        return response()->json([
            'success' => true,
            'mensaje' => 'Lista de interiores',
            'data' =>   $listainteriores
        ]);
    }

    public function guardarcontribuyente(Request $request)
    {
        $user = $request->JWT_username;
        $informacion= [];
        $informacion =  $request->all();
        $guardarcontri = $this->PersonaService->guardar_contribuyente($informacion, $user);

        return response()->json([
            'success' => true,
            'mensaje' => 'Lista de interiores',
            'data' =>   $guardarcontri
        ]);
    }
}
