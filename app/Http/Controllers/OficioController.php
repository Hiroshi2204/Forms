<?php

namespace App\Http\Controllers;

use App\Models\ClaseDocumento;
use App\Models\Documento;
use App\Models\OficinaDocumento;
use App\Models\Oficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OficioController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            //Validación básica
            if (!$request->hasFile('pdf_oficio')) {
                return response()->json(['error' => 'Archivo PDF del oficio no enviado'], 400);
            }

            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            //Guardar archivo del oficio
            $archivoOficio = $request->file('pdf_oficio');
            $pdfPathOficio = $archivoOficio->store('oficios', 'public');
            $nombreOriginalOficio = $archivoOficio->getClientOriginalName();

            $numeroLimpioO = ltrim($request->numero_oficio, '0');
            $numeroFormateadoO = str_pad($numeroLimpioO, 4, '0', STR_PAD_LEFT);
            $numeroLimpioOO = $numeroFormateadoO . "-" . now()->format('Y') . "-" . $user->username;

            $existeO = Oficio::where('codigo', $numeroLimpioOO)
                ->where('estado_registro', 'A')
                ->exists();

            if ($existeO) {
                DB::rollback();
                return response()->json(['error' => 'Oficio ya existe con número: ' . $numeroLimpioOO], 409);
            }
            // Crear el oficio
            $oficio = Oficio::create([
                'numero' => $request->numero_oficio,
                'fecha_ofi' => $request->fecha_ofi,
                'oficina_remitente' => $user->oficina->nombre,
                'codigo' => $numeroLimpioOO,
                'fecha_envio' => now(),
                'pdf_path' => $pdfPathOficio,
                'nombre_original_pdf' => $nombreOriginalOficio,
            ]);

            // Crear documentos relacionados
            $documentosCreados = [];

            foreach ($request->documentos as $docData) {
                // Validar clase_documento
                $claseDocumento = OficinaDocumento::find($docData['clase_documento_id']);
                if (!$claseDocumento) {
                    DB::rollback();
                    return response()->json(['error' => 'Clase de documento no encontrada: ' . $docData['clase_documento_id']], 404);
                }

                // Verificar acceso del usuario si no es admin
                if ($user->rol_id !== 1 && $claseDocumento->oficina_id !== $user->oficina_id) {
                    DB::rollback();
                    return response()->json(['error' => 'No tienes acceso a la clase de documento ' . $docData['clase_documento_id']], 403);
                }

                $pdfPathDoc = null;
                $nombreOriginalDoc = null;
                if (isset($docData['pdf']) && $docData['pdf'] instanceof \Illuminate\Http\UploadedFile) {
                    $pdfDoc = $docData['pdf'];
                    $pdfPathDoc = $pdfDoc->store('documentos', 'public');
                    $nombreOriginalDoc = $pdfDoc->getClientOriginalName();
                }

                $numeroLimpio = ltrim($docData['numero'], '0');
                $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
                $nomenclatura = $claseDocumento->clase_documento->nomenclatura;
                $numAnio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura;

                $existe = Documento::where('num_anio', $numAnio)
                    ->where('estado_registro', 'A')
                    ->exists();

                if ($existe) {
                    DB::rollback();
                    return response()->json(['error' => 'Documento ya existe con número: ' . $numAnio], 409);
                }

                $documento = Documento::create([
                    'nombre' => mb_strtoupper($docData['nombre'], 'UTF-8'),
                    'numero' => $numeroFormateado,
                    'anio' => now()->format('Y'),
                    'num_anio' => $numAnio,
                    'asunto' => mb_strtoupper($docData['asunto'], 'UTF-8'),
                    'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
                    'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
                    'fecha_doc' => $docData['fecha_doc'],
                    'fecha_envio' => now(),
                    'oficina_remitente' => $user->oficina->nombre,
                    'oficina_id' => $user->oficina_id,
                    'clase_documento_id' => $docData['clase_documento_id'],
                    'pdf_path' => $pdfPathDoc,
                    'nombre_original_pdf' => $nombreOriginalDoc,
                    'estado_registro' => 'A',
                    'oficio_id' => $oficio->id
                ]);

                $documentosCreados[] = $documento;
            }

            DB::commit();

            return response()->json([
                'oficio' => [
                    'numero' => $oficio->numero,
                    'fecha_ofi' => $oficio->fecha_ofi,
                    'pdf' => $oficio->pdf_path,
                ],
                'documentos' => collect($documentosCreados)->map(function ($doc) {
                    return [
                        'numero' => $doc->numero,
                        'fecha_doc' => $doc->fecha_doc,
                        'clase_documento_id' => $doc->clase_documento_id,
                        'pdf' => $doc->pdf_path,
                        'detalle' => $doc->detalle,
                        'resumen' => $doc->resumen,
                    ];
                }),
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al crear el oficio y documentos: " . $e->getMessage()], 500);
        }
    }
}
