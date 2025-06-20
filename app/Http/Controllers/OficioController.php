<?php

namespace App\Http\Controllers;

use App\Models\ClaseDocumento;
use App\Models\Documento;
use App\Models\Oficina;
use App\Models\OficinaDocumento;
use App\Models\Oficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Psy\Command\WhereamiCommand;

class OficioController extends Controller
{
    public function store1(Request $request)
    {
        DB::beginTransaction();

        try {
            if (!$request->hasFile('pdf_oficio')) {
                return response()->json(['error' => 'Archivo PDF del oficio no enviado'], 400);
            }

            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            // Guardar archivo del oficio
            $archivoOficio = $request->file('pdf_oficio');
            $pdfPathOficio = $archivoOficio->store('oficios', 'public');
            $nombreOriginalOficio = $archivoOficio->getClientOriginalName();

            // $numeroLimpioO = ltrim($request->numero_oficio, '0');
            // $numeroFormateadoO = str_pad($numeroLimpioO, 4, '0', STR_PAD_LEFT);
            // $numeroLimpioOO = $numeroFormateadoO . "-" . now()->format('Y') . "-" . $user->username;
            $numeroLimpioOO = $request->numero_oficio . "-" . now()->format('Y') . "-" . $user->username;

            $existeO = Oficio::where('codigo', $numeroLimpioOO)
                ->where('estado_registro', 'A')
                ->exists();

            if ($existeO) {
                DB::rollback();
                return response()->json(['error' => 'Oficio ya existe con número: ' . $numeroLimpioOO], 409);
            }

            // Crear el oficio
            $oficio = Oficio::create([
                //'numero' => $numeroFormateadoO,
                'numero' => $request->numero_oficio,
                'oficina_remitente' => $user->oficina->nombre,
                'codigo' => $numeroLimpioOO,
                'fecha_envio' => now(),
                'pdf_path' => $pdfPathOficio,
                'nombre_original_pdf' => $nombreOriginalOficio,
            ]);

            $documentos = [];

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'documento_') === 0) {
                    $documentos[] = json_decode($value, true);
                }
            }

            $documentosCreados = [];

            foreach ($documentos as $index => $docData) {
                $oficinaDocumento = OficinaDocumento::with('clase_documento')
                    ->where('oficina_id', $user->oficina_id)
                    ->where('clase_documento_id', $docData['clase_documento_id'])
                    ->first();
                if (!$oficinaDocumento || !$oficinaDocumento->clase_documento) {
                    DB::rollback();
                    return response()->json(['error' => 'Clase de documento o nomenclatura no encontrada: ' . $docData['clase_documento_id']], 404);
                }
                $claseOficina = Oficina::find($user->oficina_id);

                // Manejo del archivo del documento
                $pdfPathDoc = null;
                $nombreOriginalDoc = null;

                if ($request->hasFile('pdf_documento_' . $index)) {
                    $pdfDoc = $request->file('pdf_documento_' . $index);
                    $nombreOriginalDoc = $pdfDoc->getClientOriginalName();

                    $folder = 'documentos/' . now()->format('Y/m/d');
                    $filename = time() . '_' . md5($nombreOriginalDoc) . '.' . $pdfDoc->getClientOriginalExtension();
                    $pdfPathDoc = $pdfDoc->storeAs($folder, $filename, 'public');
                }

                // Generación de nombre y validación del número de documento
                $numeroLimpio = ltrim($docData['numero'], '0');
                $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
                $nomenclatura = $oficinaDocumento->clase_documento->nomenclatura;
                $nomenclatura_oficina = $claseOficina->nomenclatura;
                $numAnio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura . "-" . $nomenclatura_oficina;

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
                    'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
                    'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
                    'fecha_doc' => $docData['fecha'],
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
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if (!$request->hasFile('pdf_oficio')) {
                return response()->json(['error' => 'Archivo PDF del oficio no enviado'], 400);
            }

            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            // Guardar archivo del oficio
            $archivoOficio = $request->file('pdf_oficio');
            $pdfPathOficio = $archivoOficio->store('oficios', 'public');
            $nombreOriginalOficio = $archivoOficio->getClientOriginalName();

            $numeroLimpioOO = $request->numero_oficio . "-" . now()->format('Y') . "-" . $user->username;

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
                'oficina_remitente' => $user->oficina->nombre,
                'codigo' => $numeroLimpioOO,
                'fecha_envio' => now(),
                'pdf_path' => $pdfPathOficio,
                'nombre_original_pdf' => $nombreOriginalOficio,
            ]);

            $documentos = [];
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'documento_') === 0) {
                    $documentos[] = json_decode($value, true);
                }
            }

            $documentosCreados = [];

            foreach ($documentos as $index => $docData) {
                // 🔁 ACCESO A NOMENCLATURA SEGÚN TIPO DE USUARIO
                if ($user->oficina_id == 1) {
                    // Admin: acceso libre
                    $claseDocumento = ClaseDocumento::find($docData['clase_documento_id']);
                    if (!$claseDocumento) {
                        DB::rollback();
                        return response()->json(['error' => 'Clase de documento no encontrada: ' . $docData['clase_documento_id']], 404);
                    }
                    $nomenclatura = $claseDocumento->nomenclatura;
                } else {
                    // Usuario común: acceso restringido
                    $oficinaDocumento = OficinaDocumento::with('clase_documento')
                        ->where('oficina_id', $user->oficina_id)
                        ->where('clase_documento_id', $docData['clase_documento_id'])
                        ->first();

                    if (!$oficinaDocumento || !$oficinaDocumento->clase_documento) {
                        DB::rollback();
                        return response()->json(['error' => 'Clase de documento o nomenclatura no encontrada: ' . $docData['clase_documento_id']], 404);
                    }
                    $nomenclatura = $oficinaDocumento->clase_documento->nomenclatura;
                }

                $claseOficina = Oficina::find($user->oficina_id);

                // Manejo del archivo del documento
                $pdfPathDoc = null;
                $nombreOriginalDoc = null;

                if ($request->hasFile('pdf_documento_' . $index)) {
                    $pdfDoc = $request->file('pdf_documento_' . $index);
                    $nombreOriginalDoc = $pdfDoc->getClientOriginalName();

                    $folder = 'documentos/' . now()->format('Y/m/d');
                    $filename = time() . '_' . md5($nombreOriginalDoc) . '.' . $pdfDoc->getClientOriginalExtension();
                    $pdfPathDoc = $pdfDoc->storeAs($folder, $filename, 'public');
                }

                // Generación de nombre y validación del número de documento
                $numeroLimpio = ltrim($docData['numero'], '0');
                $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
                $nomenclatura_oficina = $claseOficina->nomenclatura;
                $numAnio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura . "-" . $nomenclatura_oficina;

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
                    'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
                    'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
                    'fecha_doc' => $docData['fecha'],
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


    public function update_copy(Request $request)
    {
        DB::beginTransaction();

        try {
            $oficio = Oficio::find($request->id);
            if (!$oficio || $oficio->estado_registro !== 'A') {
                return response()->json(['error' => 'Oficio no encontrado o inactivo'], 404);
            }

            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            // Si se envía un nuevo PDF del oficio
            if ($request->hasFile('pdf_oficio')) {
                $archivoOficio = $request->file('pdf_oficio');
                $pdfPathOficio = $archivoOficio->store('oficios', 'public');
                $oficio->pdf_path = $pdfPathOficio;
                $oficio->nombre_original_pdf = $archivoOficio->getClientOriginalName();
            }

            // Actualizar datos del oficio
            $oficio->numero = $request->numero_oficio;
            $oficio->codigo = $request->numero_oficio . "-" . now()->format('Y') . "-" . $user->username;
            $oficio->fecha_envio = now();
            $oficio->save();

            // Eliminar documentos anteriores relacionados si se requiere (opcional)
            // Documento::where('oficio_id', $oficio->id)->update(['estado_registro' => 'I']);

            // $documentos = [];
            // foreach ($request->all() as $key => $value) {
            //     if (strpos($key, 'documento_') === 0) {
            //         $documentos[] = json_decode($value, true);
            //     }
            // }

            // $documentosActualizados = [];

            // foreach ($documentos as $index => $docData) {
            //     $claseDocumento = OficinaDocumento::find($docData['clase_documento_id']);
            //     if (!$claseDocumento) {
            //         DB::rollback();
            //         return response()->json(['error' => 'Clase de documento no encontrada: ' . $docData['clase_documento_id']], 404);
            //     }

            //     $claseOficina = Oficina::find($user->oficina_id);

            //     $pdfPathDoc = null;
            //     $nombreOriginalDoc = null;

            //     if ($request->hasFile('pdf_documento_' . $index)) {
            //         $pdfDoc = $request->file('pdf_documento_' . $index);
            //         $nombreOriginalDoc = $pdfDoc->getClientOriginalName();
            //         $folder = 'documentos/' . now()->format('Y/m/d');
            //         $filename = time() . '_' . md5($nombreOriginalDoc) . '.' . $pdfDoc->getClientOriginalExtension();
            //         $pdfPathDoc = $pdfDoc->storeAs($folder, $filename, 'public');
            //     }

            //     $numeroLimpio = ltrim($docData['numero'], '0');
            //     $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
            //     $nomenclatura = $claseDocumento->clase_documento->nomenclatura;
            //     $nomenclatura_oficina = $claseOficina->nomenclatura;
            //     $numAnio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura . "-" . $nomenclatura_oficina;

            //     $existe = Documento::where('num_anio', $numAnio)
            //         ->where('estado_registro', 'A')
            //         ->exists();

            //     if ($existe) {
            //         DB::rollback();
            //         return response()->json(['error' => 'Documento ya existe con número: ' . $numAnio], 409);
            //     }

            //     $documento = Documento::create([
            //         'nombre' => mb_strtoupper($docData['nombre'], 'UTF-8'),
            //         'numero' => $numeroFormateado,
            //         'anio' => now()->format('Y'),
            //         'num_anio' => $numAnio,
            //         'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
            //         'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
            //         'fecha_doc' => $docData['fecha'],
            //         'fecha_envio' => now(),
            //         'oficina_remitente' => $user->oficina->nombre,
            //         'oficina_id' => $user->oficina_id,
            //         'clase_documento_id' => $docData['clase_documento_id'],
            //         'pdf_path' => $pdfPathDoc,
            //         'nombre_original_pdf' => $nombreOriginalDoc,
            //         'estado_registro' => 'A',
            //         'oficio_id' => $oficio->id
            //     ]);

            //     $documentosActualizados[] = $documento;
            // }

            DB::commit();

            return response()->json([
                'oficio' => [
                    'numero' => $oficio->numero,
                    'fecha_ofi' => $oficio->fecha_envio,
                    'pdf' => $oficio->pdf_path,
                ],
                // 'documentos' => collect($documentosActualizados)->map(function ($doc) {
                //     return [
                //         'numero' => $doc->numero,
                //         'fecha_doc' => $doc->fecha_doc,
                //         'clase_documento_id' => $doc->clase_documento_id,
                //         'pdf' => $doc->pdf_path,
                //         'detalle' => $doc->detalle,
                //         'resumen' => $doc->resumen,
                //     ];
                // }),
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al actualizar el oficio" . $e->getMessage()], 500);
        }
    }
    public function update_COPY3(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }

            $numeroLimpioOO = $request->input('numero') . "-" . now()->format('Y') . "-" . $user->username;

            $oficio = Oficio::findOrFail($request->id);
            $oficio->numero = $request->input('numero');
            $oficio->oficina_remitente = $user->oficina->nombre;
            $oficio->codigo = $numeroLimpioOO;
            $oficio->estado_publicacion = 0;
            $oficio->estado_registro = 'A';

            // Manejar archivo PDF del oficio
            if ($request->hasFile('pdf')) {
                $archivo = $request->file('pdf');
                $nombreOriginal = $archivo->getClientOriginalName();
                $ruta = $archivo->store('oficios', 'public');

                $oficio->pdf_path = $ruta;
                $oficio->nombre_original_pdf = $nombreOriginal;
            }

            $oficio->save();

            $documentosEnviados = collect($request->input('documentos', []));
            $idsEnviados = $documentosEnviados->pluck('id')->filter()->all();

            // Eliminar resoluciones que ya no están
            Documento::where('oficio_id', $oficio->id)
                ->whereNotIn('id', $idsEnviados)
                ->delete();

            $documentosCreados = [];

            foreach ($documentosEnviados as $index => $docData) {
                if (isset($docData['id'])) {
                    $claseDocumento = OficinaDocumento::find($docData['clase_documento_id']);
                    $claseOficina = Oficina::find($user->oficina_id);

                    $pdfDocPath = null;
                    $nombreOriginalDoc = null;

                    if (!$claseDocumento) {
                        DB::rollback();
                        return response()->json(['error' => 'Clase de documento no encontrada: ' . $docData['clase_documento_id']], 404);
                    }

                    // Actualizar resolución existente
                    $documento = Documento::find($docData['id']);

                    if ($documento) {
                        // Generación de nombre y validación del número de documento
                        $numeroLimpio = ltrim($docData['numero'], '0');
                        $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);
                        $nomenclatura = $claseDocumento->clase_documento->nomenclatura;
                        $nomenclatura_oficina = $claseOficina->nomenclatura;
                        $numAnio = $numeroFormateado . "-" . now()->format('Y') . "-" . $nomenclatura . "-" . $nomenclatura_oficina;
                        // Verifica si se envió un PDF para este documento
                        if ($request->hasFile("pdf_documento_$index")) {
                            $pdfDoc = $request->file("pdf_documento_$index");
                            $nombreOriginalDoc = $pdfDoc->getClientOriginalName();
                            $pdfDocPath = $pdfDoc->store('documentos', 'public');
                        }
                        $documento->fill([
                            'nombre' => mb_strtoupper($docData['nombre'], 'UTF-8'),
                            'numero' => str_pad(ltrim($docData['numero'], '0'), 4, '0', STR_PAD_LEFT),
                            'anio' => now()->format('Y'),
                            'num_anio' => $numAnio,
                            'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
                            'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
                            'fecha_doc' => $docData['fecha_doc'],
                            'oficina_remitente' => $user->oficina->nombre,
                            'oficina_id' => $user->oficina_id,
                            'clase_documento_id' => $docData['clase_documento_id'],
                            'oficio_id' => $oficio->id,
                            'estado_registro' => 'A',
                        ]);
                        // Solo actualiza PDF si se envió uno nuevo
                        if ($pdfDocPath) {
                            $documento->pdf_path = $pdfDocPath;
                            $documento->nombre_original_pdf = $nombreOriginalDoc;
                        }
                        $documento->save();
                    }
                } else {
                    // Crear nueva resolución
                    $numeroLimpio = ltrim($docData['numero'], '0');
                    $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);

                    $claseDocumento = OficinaDocumento::find($docData['clase_documento_id']);
                    $claseOficina = Oficina::find($user->oficina_id);

                    $nomenclatura = $claseDocumento->clase_documento->nomenclatura ?? '';
                    $nomenclatura_oficina = $claseOficina->nomenclatura ?? '';
                    $numAnio = $numeroFormateado . '-' . now()->format('Y') . '-' . $nomenclatura . '-' . $nomenclatura_oficina;

                    $existe = Documento::where('num_anio', $numAnio)
                        ->where('estado_registro', 'A')
                        ->exists();

                    if ($existe) {
                        DB::rollback();
                        return response()->json(['error' => 'Documento ya existe con número: ' . $numAnio], 409);
                    }
                    $pdfDocPath = null;
                    $nombreOriginalDoc = null;
                    if ($request->hasFile("pdf_documento_$index")) {
                        $pdfDoc = $request->file("pdf_documento_$index");
                        $nombreOriginalDoc = $pdfDoc->getClientOriginalName();
                        $pdfDocPath = $pdfDoc->store('documentos', 'public');
                    }

                    $documento = Documento::create([
                        'nombre' => mb_strtoupper($docData['nombre'], 'UTF-8'),
                        'numero' => $numeroFormateado,
                        'anio' => now()->format('Y'),
                        'num_anio' => $numAnio,
                        'resumen' => mb_strtoupper($docData['resumen'], 'UTF-8'),
                        'detalle' => mb_strtoupper($docData['detalle'], 'UTF-8'),
                        'fecha_doc' => $docData['fecha_doc'],
                        'fecha_envio' => now(),
                        'oficina_remitente' => $user->oficina->nombre,
                        'oficina_id' => $user->oficina_id,
                        'clase_documento_id' => $docData['clase_documento_id'],
                        'estado_registro' => 'A',
                        'oficio_id' => $oficio->id,
                        'pdf_path' => $pdfDocPath,
                        'nombre_original_pdf' => $nombreOriginalDoc
                    ]);

                    $documentosCreados[] = $documento;
                }
            }

            DB::commit();

            return response()->json(['mensaje' => 'Oficio y resoluciones actualizados correctamente']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Error al actualizar el oficio: ' . $e->getMessage()], 500);
        }
    }
    public function update_copy2(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }
            $numeroLimpioOO = $request->input('numero') . "-" . now()->format('Y') . "-" . $user->username;
            $oficio = Oficio::findOrFail($request->id);

            // Actualizar campos del oficio
            $oficio->numero = $request->numero_oficio;
            $oficio->oficina_remitente = $user->oficina->nombre;
            $oficio->codigo = $numeroLimpioOO;
            $oficio->estado_publicacion = 0;
            $oficio->estado_registro = 'A';

            // Reemplazar PDF si viene uno nuevo
            if ($request->hasFile('pdf_oficio')) {
                $archivo = $request->file('pdf_oficio');
                $pdfPath = $archivo->store('pdfs', 'public');
                $oficio->ruta_pdf = $pdfPath;
                $oficio->nombre_original_pdf = $archivo->getClientOriginalName();
            }

            $oficio->save();

            // IDs de resoluciones enviadas
            $resolucionesIdsEnviadas = [];

            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'pdf_documento_') && is_string($value)) {
                    $json = json_decode($value, true);

                    if (isset($json['id'])) {
                        // Actualizar existente
                        $resolucion = Documento::find($json['id']);
                        if ($resolucion) {
                            $resolucion->update([
                                'clase_documento_id' => $json['clase_documento_id'],
                                'nombre' => $json['nombre'],
                                'numero' => $json['numero'],
                                'fecha_doc' => $json['fecha'],
                                'resumen' => $json['resumen'],
                                'detalle' => $json['detalle'],
                            ]);
                            $resolucionesIdsEnviadas[] = $resolucion->id;
                        }
                    } else {
                        // Crear nueva resolución
                        $res = new Documento([
                            'oficio_id' => $oficio->id,
                            'clase_documento_id' => $json['clase_documento_id'],
                            'nombre' => $json['nombre'],
                            'numero' => $json['numero'],
                            'fecha_doc' => $json['fecha'],
                            'resumen' => $json['resumen'],
                            'detalle' => $json['detalle'],
                        ]);
                        $res->save();
                        $resolucionesIdsEnviadas[] = $res->id;
                    }
                } elseif (str_starts_with($key, 'pdf_documento_') && $request->file($key)) {
                    // Subir archivo PDF correspondiente
                    $index = str_replace('pdf_documento_', '', $key);
                    $file = $request->file($key);
                    $resolucion = Documento::where('oficio_id', $oficio->id)->latest()->first();
                    if ($resolucion) {
                        $path = $file->store('pdfs', 'public');
                        $resolucion->ruta_pdf = $path;
                        $resolucion->nombre_original_pdf = $file->getClientOriginalName();
                        $resolucion->save();
                    }
                }
            }

            // Eliminar resoluciones que ya no están en el request
            Documento::where('oficio_id', $oficio->id)
                ->whereNotIn('id', $resolucionesIdsEnviadas)
                ->delete();

            DB::commit();

            return response()->json(['mensaje' => 'Oficio actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al actualizar', 'detalles' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();
            if (!$user || !$user->oficina) {
                return response()->json(['error' => 'Usuario o oficina no encontrada'], 403);
            }
            $numeroLimpioOO = $request->numero . "-" . now()->format('Y') . "-" . $user->username;
            // Validar ID
            $oficio = Oficio::findOrFail($request->id);

            // Actualizar oficio
            $oficio->numero = $request->numero;
            $oficio->codigo = $numeroLimpioOO;

            // Si se envió nuevo PDF
            if ($request->hasFile('pdf')) {
                $archivo = $request->file('pdf');
                $path = $archivo->store('pdfs', 'public');
                $oficio->pdf_path = $path;
                $oficio->nombre_original_pdf = $archivo->getClientOriginalName();
            }

            $oficio->save();

            // IDs que vienen del formulario
            $resolucionesIdsEnviadas = [];

            // Procesar cada entrada datos_documento_X
            foreach ($request->all() as $key => $value) {
                if (str_starts_with($key, 'datos_documento_')) {
                    $index = str_replace('datos_documento_', '', $key);
                    $json = json_decode($value, true);

                    if (!$json) continue;

                    // Preparar valores base
                    $numeroLimpio = ltrim($json['numero'], '0');
                    $numeroFormateado = str_pad($numeroLimpio, 4, '0', STR_PAD_LEFT);

                    $claseDocumento = ClaseDocumento::findOrFail($json['clase_documento_id']);
                    $nomenclatura = $claseDocumento->nomenclatura;

                    $oficina = $user->oficina;
                    $nomenclatura_oficina = $oficina->nomenclatura;

                    $anio = now()->format('Y');
                    $numAnio = "{$numeroFormateado}-{$anio}-{$nomenclatura}-{$nomenclatura_oficina}";

                    // Construir arreglo de datos
                    $documentoData = [
                        'oficio_id' => $oficio->id,
                        'clase_documento_id' => $json['clase_documento_id'],
                        'nombre' => mb_strtoupper($json['nombre'], 'UTF-8'),
                        'numero' => $numeroFormateado,
                        'fecha_doc' => $json['fecha'],
                        'resumen' => mb_strtoupper($json['resumen'], 'UTF-8'),
                        'detalle' => mb_strtoupper($json['detalle'], 'UTF-8'),
                        'anio' => $anio,
                        'num_anio' => $numAnio,
                        'fecha_envio' => now(),
                        'oficina_remitente' => $oficina->nombre,
                        'oficina_id' => $oficina->id,
                    ];

                    $res = Documento::updateOrCreate(
                        ['id' => $json['id'] ?? null],
                        $documentoData
                    );

                    // Subir PDF si se envió archivo
                    $archivoKey = "archivo_documento_$index";
                    if ($request->hasFile($archivoKey)) {
                        $archivoDoc = $request->file($archivoKey);
                        $ruta = $archivoDoc->store('pdfs', 'public');
                        $res->pdf_path = $ruta;
                        $res->nombre_original_pdf = $archivoDoc->getClientOriginalName();
                        $res->save();
                    }

                    $resolucionesIdsEnviadas[] = $res->id;
                }
            }

            // Mantener solo los documentos enviados (no eliminar los no enviados)
            // Si quieres eliminar los que ya no están, descomenta lo siguiente:

            Documento::where('oficio_id', $oficio->id)
                ->whereNotIn('id', $resolucionesIdsEnviadas)
                ->update(['estado_registro' => 'I']);


            DB::commit();
            return response()->json(['mensaje' => 'Oficio actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al actualizar el oficio',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }





    public function filtro_oficio()
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            // Si el usuario es administrador (rol = 1), obtiene todos los oficios
            if ($user->rol->id == 1) {
                $oficios = Oficio::select('numero')
                    ->where('estado_registro', 'A')
                    ->get();
            } else {
                // Si es usuario común (rol = 2), solo los de su oficina
                $oficios = Oficio::where('oficina_remitente', $user->oficina->nombre)
                    ->select('numero')
                    ->where('estado_registro', 'A')
                    ->get();
            }

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al obtener los oficios y documentos: " . $e->getMessage()
            ], 500);
        }
    }

    public function get_oficios_documentos()
    {
        DB::beginTransaction();
        $user = auth()->user();
        try {

            $oficios = Oficio::with('documentos')
                ->where('oficina_remitente', $user->oficina->nombre)
                ->get();

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener los oficios y documentos: " . $e->getMessage()], 500);
        }
    }
    public function get_oficios1()
    {
        DB::beginTransaction();
        $user = auth()->user();
        try {

            $oficios = Oficio::with('documentos')
                ->where('oficina_remitente', $user->oficina->nombre)
                ->get();

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener los oficios y documentos: " . $e->getMessage()], 500);
        }
    }
    public function get_oficios()
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            // Si el usuario es administrador (rol = 1), obtiene todos los oficios paginados
            if ($user->rol->id == 1) {
                $oficios = Oficio::with('documentos')->get();
            } else {
                // Si es usuario común (rol = 2), solo los de su oficina paginados
                $oficios = Oficio::with('documentos')
                    ->where('oficina_remitente', $user->oficina->nombre)
                    ->get();
            }

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al obtener los oficios y documentos: " . $e->getMessage()
            ], 500);
        }
    }



    public function get_oficios_id1(Request $request)
    {
        DB::beginTransaction();
        $user = auth()->user();
        try {

            $oficio = Oficio::with(['documentos' => function ($q) {
                $q->where('estado_registro', 'A');
            }])
                ->where('oficina_remitente', $user->oficina->nombre)
                ->where('id', $request->id)
                ->where('estado_registro', 'A')
                ->first();
            DB::commit();
            return response()->json([
                'oficio' => $oficio,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener los oficios y documentos: " . $e->getMessage()], 500);
        }
    }
    public function get_oficios_id(Request $request)
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            // Construimos la consulta base
            $query = Oficio::with(['documentos' => function ($q) {
                $q->where('estado_registro', 'A');
            }])
                ->where('id', $request->id)
                ->where('estado_registro', 'A');


            if (!$user->rol->id == 1) {
                $query->where('oficina_remitente', $user->oficina->nombre);
            }

            $oficio = $query->first();

            DB::commit();

            return response()->json([
                'oficio' => $oficio,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al obtener los oficios y documentos: " . $e->getMessage()
            ], 500);
        }
    }



    public function get_oficios_pendientes()
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            // Si el usuario es administrador (rol = 1), obtiene todos los oficios
            if ($user->rol->id == 1) {
                $oficios = Oficio::with('documentos')
                    ->where('estado_publicacion', 0)
                    ->get();
            } else {
                // Si es usuario común (rol = 2), solo los de su oficina
                $oficios = Oficio::with('documentos')
                    ->where('oficina_remitente', $user->oficina->nombre)
                    ->where('estado_publicacion', 0)
                    ->get();
            }

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al obtener los oficios y documentos: " . $e->getMessage()
            ], 500);
        }
    }
    public function get_oficios_publicados()
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            // Si el usuario es administrador (rol = 1), obtiene todos los oficios
            if ($user->rol->id == 1) {
                $oficios = Oficio::with('documentos')
                    ->where('estado_publicacion', 1)
                    ->get();
            } else {
                // Si es usuario común (rol = 2), solo los de su oficina
                $oficios = Oficio::with('documentos')
                    ->where('oficina_remitente', $user->oficina->nombre)
                    ->where('estado_publicacion', 1)
                    ->get();
            }

            DB::commit();

            return response()->json([
                'oficios' => $oficios,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al obtener los oficios y documentos: " . $e->getMessage()
            ], 500);
        }
    }
}
