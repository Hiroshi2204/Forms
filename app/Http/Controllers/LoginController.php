<?php

namespace App\Http\Controllers;

use App\Models\AlmacenProducto;
use App\Models\Destinatario;
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

        $user = User::with('persona')->where('id', $username)->where('estado_registro', 'A')->first();

        if (!$user) {
            return redirect()->route('login');
            //return response()->json(['error' => 'Usuario bloqueado'], 402);
        }
        $response = [
            "nombres" => $user->persona->nombres,
            "apellido_paterno" => $user->persona->apellido_paterno,
            "apellido_materno" => $user->persona->apellido_materno,
            "username" => $user->username,
            "celular" => $user->persona->celular,
            "correo" => $user->persona->correo,
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

                $numDocumentoCompleto = $request->num_documento . '-' . $request->anio;

                // Guardar en base de datos incluyendo el nombre original
                $formulario = Formulario::create([
                    'num_documento' => $numDocumentoCompleto,
                    'asunto' => $request->asunto,
                    'fecha_registro' => $request->fecha_registro,
                    'fecha_publicacion' => $request->fecha_publicacion,
                    'pdf_path' => $pdfPath,
                    'nombre_original' => $nombreOriginal
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

        $resultados = Formulario::where('num_documento', 'like', "%$q%")
            ->orWhere('asunto', 'like', "%$q%")
            ->orWhere('nombre_original', 'like', "%$q%")
            ->get();

        return response()->json($resultados);
    }
}
