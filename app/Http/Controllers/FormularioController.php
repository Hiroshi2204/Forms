<?php

namespace App\Http\Controllers;

use App\Models\ClaseDocumento;
use App\Models\Documento;
use App\Models\TipoTransparenciaDetalle;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormularioController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('pdf')) {
                $archivo = $request->file('pdf');
                $pdfPath = $archivo->store('pdfs', 'public');
                $nombreOriginal = $archivo->getClientOriginalName();

                $user = auth()->user();
                if (!$user || !$user->oficina) {
                    return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
                }

                $formulario = Documento::create([
                    'nombre' => $request->nombre,
                    'numero' => $request->numero,
                    'anio' => $request->anio,
                    'asunto' => $request->asunto,
                    'resumen' => $request->resumen,
                    'fecha_doc' => $request->fecha_doc,
                    'fecha_envio' => now(),
                    'oficina_remitente' => $user->oficina->nombre,
                    'clase_documento_id' => $request->clase_documento_id,
                    'pdf_path' => $pdfPath,
                    'nombre_original_pdf' => $nombreOriginal
                ]);

                if ($formulario->clase_documento->oficina_id != $user->id)
                    return response()->json(['error' => 'El usuario no tiene accesos'], 400);
                DB::commit();
                $formulario->load('clase_documento.tipo_transparencia', 'clase_documento.oficina.cargo_oficina');
                return response()->json([
                    'message' => 'Documento creado exitosamente',
                    'documento' => $formulario
                ], 201);
            } else {
                return response()->json(['error' => 'Archivo PDF no enviado'], 400);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al crear el registro: " . $e->getMessage()], 500);
        }
    }


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

    public function get_id()
    {
        $user = auth()->user();
        DB::beginTransaction();
        //return response()->json($user->id);
        try {
            $resultados = ClaseDocumento::select('id', 'nombre', 'nomenclatura')
                ->where('oficina_id', $user->id)
                ->get();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

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

    public function descargarPdf(Request $request)
    {
        try {
            $id = $request->input('id');
            $documento = Documento::find($id);

            if (!$documento || !$documento->pdf_path) {
                return response()->json(['error' => 'Documento o archivo no encontrado'], 404);
            }

            // Ruta completa al archivo en el disco 'public'
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
}
