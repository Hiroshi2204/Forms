<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class FormularioController extends Controller
{
    public function mostrar_formulario()
    {
        return view('formulario_transparencia');
    }
    public function store(Request $request)
{
    DB::beginTransaction();
    try {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('pdf')) {
            $archivo = $request->file('pdf');

            // Guarda el archivo con nombre hasheado en 'storage/app/public/pdfs'
            $pdfPath = $archivo->store('pdfs', 'public');

            // Captura el nombre original del archivo
            $nombreOriginal = $archivo->getClientOriginalName();

            $numDocumentoCompleto = $request->num_documento . '-' . $request->anio;

            // Guardar en base de datos incluyendo el nombre original
            $formulario=Formulario::create([
                'num_documento' => $numDocumentoCompleto,
                'asunto' => $request->asunto,
                'fecha_registro' => $request->fecha_registro,
                'fecha_publicacion' => $request->fecha_publicacion,
                'pdf_path' => $pdfPath,
                'nombre_original' => $nombreOriginal
            ]);

            DB::commit();
            return redirect()->route('mostrar_formulario')->with('success', 'Registro creado correctamente');
        }
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["resp" => "Error al crear Registro: " . $e->getMessage()], 500);
    }
}
    public function buscar(Request $request)
    {
        $q = $request->input('q');

        $resultados = Formulario::where('num_documento', 'like', "%$q%")
            ->orWhere('asunto', 'like', "%$q%")
            ->orWhere('nombre_original', 'like', "%$q%")
            ->get();

        return response()->json($resultados);
    }
    
}
