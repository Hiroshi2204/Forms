<?php

namespace App\Http\Controllers;

use App\Models\ClaseDocumento;
use App\Models\Documento;
use App\Models\Oficina;
use App\Models\OficinaDocumento;
use App\Models\TipoTransparencia;
use App\Models\TipoTransparenciaDetalle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormularioController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/documentos",
     *     summary="Crear un nuevo documento",
     *     description="Crea un documento con validación de rol y oficina, y sube un PDF.",
     *     operationId="crearDocumento",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"pdf", "numero", "nombre", "asunto", "resumen", "fecha_doc", "clase_documento_id"},
     *                 @OA\Property(property="pdf", type="file", description="Archivo PDF"),
     *                 @OA\Property(property="numero", type="string", example="001"),
     *                 @OA\Property(property="nombre", type="string", example="Documento ejemplo"),
     *                 @OA\Property(property="asunto", type="string", example="Asunto del documento"),
     *                 @OA\Property(property="resumen", type="string", example="Resumen del documento"),
     *                 @OA\Property(property="fecha_doc", type="string", format="date", example="2025-06-09"),
     *                 @OA\Property(property="clase_documento_id", type="integer", example=3)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Documento creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Documento creado exitosamente"),
     *             @OA\Property(property="documento", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Archivo PDF no enviado o sin acceso"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuario o oficina no encontrada"
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Documento duplicado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if (!$request->hasFile('pdf')) {
                return response()->json(['error' => 'Archivo PDF no enviado'], 400);
            }

            $archivo = $request->file('pdf');
            $pdfPath = $archivo->store('pdfs', 'public');
            $nombreOriginal = $archivo->getClientOriginalName();

            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            $claseDocumento = ClaseDocumento::with('oficina')->find($request->clase_documento_id);
            if (!$claseDocumento) {
                return response()->json(['error' => 'Clase de documento no encontrada'], 404);
            }

            if ($user->rol_id !== 1) {
                if ($claseDocumento->oficina_id !== $user->oficina_id) {
                    return response()->json(['error' => 'No tienes acceso a esta clase de documento'], 403);
                }
            }

            $nomenclatura = ClaseDocumento::where('id', $request->clase_documento_id)->value('nomenclatura');
            $numeroLimpio = ltrim($request->numero, '0');
            $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
            $numeroLimpio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura;
            //$numeroLimpio = $numeroFormateado . "-" . $request->anio . "-" . $nomenclatura;


            $existe = Documento::where('num_anio', $numeroLimpio)
                ->where('estado_registro', 'A')
                ->exists();

            if ($existe) {
                return response()->json(['error' => 'Ya existe un documento activo con el mismo número, año y nomenclatura'], 409);
            }

            $formulario = Documento::create([
                'nombre' => mb_strtoupper($request->nombre, 'UTF-8'),
                'numero' => $numeroFormateado,
                'anio' => now()->format('Y'),
                //'anio' => $request->anio,
                'num_anio' => $numeroLimpio,
                'asunto' => mb_strtoupper($request->asunto, 'UTF-8'),
                'resumen' => mb_strtoupper($request->resumen, 'UTF-8'),
                'fecha_doc' => $request->fecha_doc,
                'fecha_envio' => now(),
                'oficina_remitente' => $user->oficina->nombre,
                'clase_documento_id' => $request->clase_documento_id,
                'pdf_path' => $pdfPath,
                'nombre_original_pdf' => $nombreOriginal,
                'estado_registro' => 'A'
            ]);
            DB::commit();

            $formulario->load('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina');

            return response()->json([
                'message' => 'Documento creado exitosamente',
                'documento' => $formulario
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al crear el registro: " . $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/documentos/buscar",
     *     summary="Buscar documentos",
     *     description="Busca documentos activos usando un término de búsqueda general en campos como nombre, número, asunto, resumen, fechas y más.",
     *     operationId="buscarDocumentos",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Término de búsqueda",
     *         required=true,
     *         @OA\Schema(type="string", example="resolución")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de documentos encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="last_page", type="integer", example=5),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="total", type="integer", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno al buscar documentos"
     *     )
     * )
     */

    public function buscar(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('nombre', 'like', "%$q%")
                        ->orWhere('numero', 'like', "%$q%")
                        ->orWhere('asunto', 'like', "%$q%")
                        ->orWhere('resumen', 'like', "%$q%")
                        ->orWhere('fecha_doc', 'like', "%$q%")
                        ->orWhere('oficina_remitente', 'like', "%$q%")
                        ->orWhere('nombre_original_pdf', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function buscar_parametro(Request $request)
    {
        try {
            $query = Documento::with('clase_documento.tipo_transparencia', 'oficina', 'oficio')
                ->where('estado_registro', 'A');

            if ($request->filled('nombre')) {
                $query->where('nombre', 'like', '%' . $request->nombre . '%');
            }

            if ($request->filled('numero')) {
                $query->where('numero', 'like', '%' . $request->numero . '%');
            }

            if ($request->filled('asunto')) {
                $query->where('asunto', 'like', '%' . $request->asunto . '%');
            }

            if ($request->filled('resumen')) {
                $query->where('resumen', 'like', '%' . $request->resumen . '%');
            }

            if ($request->filled('fecha_doc')) {
                $query->where('fecha_doc', 'like', '%' . $request->fecha_doc . '%');
            }

            if ($request->filled('oficina_id')) {
                $query->where('oficina_id', 'like', '%' . $request->oficina_id . '%');
            }

            // Oficio (relación directa)
            if ($request->filled('oficio_id')) {
                $query->where('oficio_id', $request->oficio_id);  // Asumiendo que Documento tiene oficio_id como FK
            }

            if ($request->filled('nombre_original_pdf')) {
                $query->where('nombre_original_pdf', 'like', '%' . $request->nombre_original_pdf . '%');
            }

            $resultados = $query->paginate(10);

            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }



    public function buscar_nombre(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('nombre', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function buscar_numero(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('numero', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function buscar_asunto(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('asunto', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }
    public function buscar_resumen(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('resumen', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function buscar_fecha(Request $request)
    {
        try {
            $q = $request->input('q');

            $resultados = Documento::with('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina')
                ->where('estado_registro', 'A')
                ->where(function ($query) use ($q) {
                    $query->where('fecha_doc', 'like', "%$q%");
                })
                ->paginate(10);
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/documentos/get",
     *     summary="Obtener clases de documentos",
     *     description="Retorna una lista de clases de documentos con sus campos: id, nombre y nomenclatura.",
     *     operationId="obtenerClasesDocumentos",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clases de documentos",
     *         @OA\JsonContent(
     *             @OA\Property(property="documentos", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nombre", type="string", example="Resolución"),
     *                     @OA\Property(property="nomenclatura", type="string", example="RES")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno al obtener clases de documentos"
     *     )
     * )
     */

    public function get()
    {
        DB::beginTransaction();
        try {
            $resultados = ClaseDocumento::select('id', 'nombre', 'nomenclatura')->get();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function get_oficinas()
    {
        DB::beginTransaction();
        try {
            $resultados = Oficina::select('id', 'nombre')
            ->where('id', '<>', 1)
            ->get();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/documentos/get_id",
     *     summary="Obtener clases de documentos por oficina",
     *     description="Devuelve clases de documentos asignadas a la oficina del usuario autenticado.",
     *     operationId="obtenerClasesDocumentosPorOficina",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de clases de documentos filtradas por oficina",
     *         @OA\JsonContent(
     *             @OA\Property(property="documentos", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="nombre", type="string", example="Informe Técnico"),
     *                     @OA\Property(property="nomenclatura", type="string", example="INF")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno al obtener clases de documentos"
     *     )
     * )
     */

    public function get_id()
    {
        $user = auth()->user();
        DB::beginTransaction();

        try {
            if ($user->rol_id === 1) {
                // Admin: todas las clases de documento
                $resultados = ClaseDocumento::all();
            } else {
                // Usuario: clases según su oficina
                $claseIds = OficinaDocumento::where('oficina_id', $user->oficina_id)
                    ->pluck('clase_documento_id');

                $resultados = ClaseDocumento::whereIn('id', $claseIds)->get();
            }

            DB::commit();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }




    /**
     * @OA\Post(
     *     path="/api/documentos/eliminar",
     *     summary="Eliminar (inhabilitar) un documento",
     *     description="Cambia el estado de un documento a 'I' (inhabilitado) por su ID.",
     *     operationId="eliminarDocumento",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=12, description="ID del documento a inhabilitar")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Documento inhabilitado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Estado actualizado correctamente"),
     *             @OA\Property(property="documento", type="object",
     *                 @OA\Property(property="id", type="integer", example=12),
     *                 @OA\Property(property="estado_registro", type="string", example="I")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Documento no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno al actualizar estado del documento"
     *     )
     * )
     */

    public function eliminar(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            $documento = Documento::find($id);

            if (!$documento) {
                return response()->json(['error' => 'Documento no encontrado'], 404);
            }

            $documento->estado_registro = "I";
            $documento->save();
            DB::commit();

            return response()->json([
                'message' => 'Estado actualizado correctamente',
                'documento' => $documento
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo cambiar el estado: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/documentos/descargar",
     *     summary="Descargar PDF de un documento",
     *     description="Permite descargar el archivo PDF asociado a un documento usando su ID.",
     *     operationId="descargarPdfDocumento",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=5, description="ID del documento que contiene el PDF")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Archivo PDF descargado exitosamente",
     *         @OA\Schema(type="file")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Documento o archivo no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al descargar el archivo"
     *     )
     * )
     */

    public function descargarPdf(Request $request)
    {
        try {
            $id = $request->input('id');
            $documento = Documento::find($id);

            if (!$documento || !$documento->pdf_path) {
                return response()->json(['error' => 'Documento o archivo no encontrado'], 404);
            }

            $filePath = storage_path('app/public/' . $documento->pdf_path);

            if (!file_exists($filePath)) {
                return response()->json(['error' => 'Archivo no encontrado en el servidor'], 404);
            }

            return response()->download($filePath, $documento->nombre_original_pdf);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo descargar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/documentos/get/anio",
     *     summary="Obtener lista de documentos únicos por año actual",
     *     description="Devuelve una lista de valores únicos del campo 'num_anio' de los documentos activos del año actual.",
     *     operationId="filtroDocumentos",
     *     tags={"Documentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de documentos obtenida exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="documentos",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="num_anio", type="string", example="001-2025-OFI")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener las resoluciones"
     *     )
     * )
     */

    public function filtro(Request $request)
    {
        $user = auth()->user();
        DB::beginTransaction();

        try {
            $nomenclatura = ClaseDocumento::where('id', $request->clase_documento_id)->value('id');
            $anioActual = date('Y');
            //$oficina = ClaseDocumento::where('oficina_id', $user->oficina_id);
            $resultados = Documento::select('num_anio')
                ->where('anio', $anioActual)
                ->where('oficina_remitente', $user->oficina->nombre)
                ->where('clase_documento_id', $nomenclatura)
                ->where('estado_registro', 'A')
                ->distinct()
                ->get();

            DB::commit();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }
}
