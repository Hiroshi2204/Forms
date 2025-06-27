<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VistaController extends Controller
{
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

            if ($request->filled('resumen')) {
                $query->where('resumen', 'like', '%' . $request->resumen . '%');
            }

            if ($request->filled('detalle')) {
                $query->where('detalle', 'like', '%' . $request->detalle . '%');
            }

            if ($request->filled('fecha_doc')) {
                $query->where('fecha_doc', 'like', '%' . $request->fecha_doc . '%');
            }

            // Filtro por rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha_doc', [$request->fecha_inicio, $request->fecha_fin]);
            }

            if ($request->filled('oficina_id')) {
                $query->where('oficina_id', 'like', '%' . $request->oficina_id . '%');
            }

            if ($request->filled('oficio_id')) {
                $query->where('oficio_id', $request->oficio_id);
            }

            if ($request->filled('nombre_original_pdf')) {
                $query->where('nombre_original_pdf', 'like', '%' . $request->nombre_original_pdf . '%');
            }

            if ($request->filled('orden_campo') && $request->filled('orden_direccion')) {
                $query->orderBy($request->orden_campo, $request->orden_direccion);
            } else {
                $query->orderByDesc('fecha_doc'); // orden por defecto si no se envía ordenamiento
            }

            $resultados = $query->paginate(10);

            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function get_oficinas_public()
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

    public function get_oficinas_facultades()
    {
        DB::beginTransaction();
        try {
            $resultados = Oficina::select('id', 'nombre')
                ->whereBetween('id', [2, 13])
                ->get();

            return response()->json([
                'documentos' => $resultados
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }

    public function buscar_normas_resoluciones(Request $request)
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

            if ($request->filled('resumen')) {
                $query->where('resumen', 'like', '%' . $request->resumen . '%');
            }

            if ($request->filled('detalle')) {
                $query->where('detalle', 'like', '%' . $request->detalle . '%');
            }

            if ($request->filled('fecha_doc')) {
                $query->where('fecha_doc', 'like', '%' . $request->fecha_doc . '%');
            }

            // Filtro por rango de fechas
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $query->whereBetween('fecha_doc', [$request->fecha_inicio, $request->fecha_fin]);
            }

            if ($request->filled('oficina_id')) {
                $query->where('oficina_id', 'like', '%' . $request->oficina_id . '%');
            }

            if ($request->filled('oficio_id')) {
                $query->where('oficio_id', $request->oficio_id);
            }

            if ($request->filled('nombre_original_pdf')) {
                $query->where('nombre_original_pdf', 'like', '%' . $request->nombre_original_pdf . '%');
            }

            if ($request->filled('orden_campo') && $request->filled('orden_direccion')) {
                $query->orderBy($request->orden_campo, $request->orden_direccion);
            } else {
                $query->orderByDesc('fecha_doc'); // orden por defecto si no se envía ordenamiento
            }

            $resultados = $query->paginate(10);

            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al obtener las resoluciones: " . $e->getMessage()], 500);
        }
    }
}
