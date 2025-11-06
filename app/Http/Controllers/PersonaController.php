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
        try {

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
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function listardocidentidad(Request $request)
    {
        try {

            $listardocidentidad = $this->PersonaService->listar_doc_identidad();

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo de Documentos de Identidad',
                'data' =>   $listardocidentidad
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function listamotivos(Request $request)
    {
        try {
            $id = $request->idcanal;
            $area = $request->area;

            $listarmotivos = $this->PersonaService->listar_motivos($id, $area);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado motivos',
                'data' =>   $listarmotivos
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }


    public function listardepartamentos()
    {
        try {

            $listardepartamentos = $this->PersonaService->listar_departamentos();

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo dedepartamentos',
                'data' =>   $listardepartamentos
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listarprovincias(Request $request)
    {
        try {
            $id = $request->id;
            $desc = $request->desc;

            $listarprovincias = $this->PersonaService->listar_provincias($id, $desc);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo  provincia',
                'data' =>   $listarprovincias
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function listardistritos(Request $request)
    {
        try {
            $id = $request->id;
            $desc = $request->desc ;
            $listardistritos = $this->PersonaService->listar_distritos($id, $desc);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo distritos',
                'data' =>   $listardistritos
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listarurbanizaciones()
    {
        try {

            $listarurbanizaciones = $this->PersonaService->listar_urbanizaciones();

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo de urbanizaciones',
                'data' =>   $listarurbanizaciones
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }


    public function listarvias(Request $request)
    {
        try {

            $ubigeo = $request->ubigeo;
            $listarvias = $this->PersonaService->listar_vias($ubigeo);

            return response()->json([
                'success' => true,
                'mensaje' => 'Listado completo de vias',
                'data' =>   $listarvias
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function detallemesaayuda(Request $request)
    {
        try {
            $anio = $request->anio;
            $codigo = $request->codigo;
            $tipo = $request->tipo;
            $datadocumento = $this->PersonaService->detalle_documento($anio,$codigo,$tipo );

            return response()->json([
                'success' => true,
                'mensaje' => 'Datos del documento',
                'data' =>   $datadocumento
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function listarinteriores(Request $request)
    {
        try {

            $listainteriores = $this->PersonaService->listar_interiores();


            return response()->json([
                'success' => true,
                'mensaje' => 'Lista de interiores',
                'data' =>   $listainteriores
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }

    public function guardarcontribuyente(Request $request)
    {
        try {
            $JWT_token = $request->JWT_token;
            $user = $this->authService->user_magic_ad_match($JWT_token);
            $informacion= [];
            $informacion =  $request->all();
            $guardarcontri = $this->PersonaService->guardar_contribuyente($informacion, $user);

            return response()->json([
                'success' => true,
                'mensaje' => 'Lista de interiores',
                'data' =>   $guardarcontri
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
