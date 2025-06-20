<?php

namespace App\Http\Controllers;

use App\Models\Oficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function publicar(Request $request)
    {
        DB::beginTransaction();
        $user = auth()->user();

        try {
            if ($user->rol->id != 1) {
                return response()->json(["error" => "No eres administrador"], 403); // Código HTTP 403 es más adecuado
            }

            $ids = $request->input('ids', []);

            if (!is_array($ids) || empty($ids)) {
                return response()->json(["error" => "No se enviaron IDs válidos de oficios"], 400);
            }

            foreach ($ids as $id) {
                $oficio = Oficio::with('documentos')->find($id);
                if ($oficio) {
                    $oficio->estado_publicacion = 1;
                    $oficio->fecha_publicacion = now();
                    $oficio->save();

                    // Actualiza documentos relacionados si existen
                    foreach ($oficio->documentos as $documento) {
                        $documento->estado_publicacion = 1;
                        $documento->fecha_publicacion = now();
                        $documento->save();
                    }
                }
            }

            DB::commit();

            return response()->json([
                'mensaje' => 'Oficios y documentos actualizados correctamente'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Error al actualizar el oficio: " . $e->getMessage()], 500);
        }
    }

    public function despublicar(Request $request)
{
    DB::beginTransaction();

    $user = auth()->user();

    try {
        if ($user->rol->id != 1) {
            return response()->json(["error" => "No eres administrador"], 403);
        }

        $id = $request->input('id');

        if (!$id) {
            return response()->json(["error" => "No se envió un ID válido"], 400);
        }

        $oficio = Oficio::with('documentos')->find($id);

        if (!$oficio) {
            return response()->json(["error" => "Oficio no encontrado"], 404);
        }

        // Marcar el oficio como no publicado
        $oficio->estado_publicacion = 0;
        $oficio->fecha_publicacion = null;
        $oficio->save();

        // Marcar documentos relacionados como no publicados
        foreach ($oficio->documentos as $documento) {
            $documento->estado_publicacion = 0;
            $documento->fecha_publicacion = null;
            $documento->save();
        }

        DB::commit();

        return response()->json([
            'mensaje' => 'Oficio y documentos despublicados correctamente'
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(["error" => "Error al despublicar el oficio: " . $e->getMessage()], 500);
    }
}
}
