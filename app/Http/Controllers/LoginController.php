<?php

namespace App\Http\Controllers;

use App\Models\AlmacenProducto;
use App\Models\Destinatario;
use App\Models\Documento;
use App\Models\EgresosAdicionales;
use App\Models\Formulario;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoDetalle;
use App\Models\Proveedor;
use App\Models\RegistroEntrada;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalida;
use App\Models\RegistroSalidaDetalle;
use App\Models\Trabajador;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    public function mostrar_login()
    {
        return view('mostrar_login');
    }
    public function mostrar_formulario($username)
    {
        $usernameu = User::where('id', $username)->first();

        if (!$usernameu) {
            return redirect()->route('login');
            //return response()->json(["error" => "El nombre de usuario no existe"], 400);
        }

        $user = User::with('oficina')->where('id', $username)->where('estado_registro', 'A')->first();

        if (!$user) {
            return redirect()->route('login');
            //return response()->json(['error' => 'Usuario bloqueado'], 402);
        }
        $response = [
            "id" => $user->id
        ];
        return view('formulario_transparencia', $response);
    }
    public function store(Request $request, $id)
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

                $user = User::with('oficina')->where('id', $id)->first();

                // Guardar en base de datos incluyendo el nombre original
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

                DB::commit();
                return redirect()->route('mostrar_formulario', ['id' => $id])->with('success', 'Registro creado correctamente');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["resp" => "Error al crear Registro: " . $e->getMessage()], 500);
        }
    }
    public function buscar(Request $request)
    {
        $q = $request->input('q');

        $resultados = Documento::where('nombre', 'like', "%$q%")
            ->orWhere('numero', 'like', "%$q%")
            ->orWhere('asunto', 'like', "%$q%")
            ->orWhere('resumen', 'like', "%$q%")
            ->orWhere('fecha_doc', 'like', "%$q%")
            ->orWhere('oficina_remitente', 'like', "%$q%")
            ->orWhere('nombre_original_pdf', 'like', "%$q%")
            ->get();

        return response()->json($resultados);
    }
}
