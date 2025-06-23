<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\EgresosAdicionales;
use App\Models\Oficina;
use App\Models\Oficio;
use App\Models\Producto;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalidaDetalle;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportePDFController extends Controller
{

    public function descargarReporteEjemplo(Request $request)
    {
        $oficios = Oficio::whereMonth('fecha_envio', $request->mes ?? now()->month)
            ->where('estado_publicacion', 0)
            ->get();


        $mesNumero = $request->mes ?? now()->month;
        $nombreMes = \Carbon\Carbon::create()->month($mesNumero)->locale('es')->isoFormat('MMMM');
        $anio = now()->year;

        $pdf = Pdf::loadView('oficios_ejemplo', compact('oficios', 'nombreMes', 'anio'));

        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $metrics = $dompdf->getFontMetrics();

        $font = $metrics->getFont('helvetica', 'bold');
        $width = $canvas->get_width();

        $logoPath = public_path('img/logo_header.png');

        if (!file_exists($logoPath)) {
            abort(500, "No se encontró la imagen del encabezado: $logoPath");
        }

        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($font, $logoPath, $metrics, $width) {
            // Logo institucional
            $canvas->image($logoPath, 30, 15, 60, 60);

            // Texto 1 centrado
            $text1 = 'UNIVERSIDAD NACIONAL DEL CALLAO';
            $textWidth1 = $metrics->getTextWidth($text1, $font, 12);
            $canvas->text(($width - $textWidth1) / 2, 30, $text1, $font, 12);

            // Texto 2 centrado
            $text2 = 'OFICINA DE TECNOLOGÍAS DE INFORMACIÓN';
            $textWidth2 = $metrics->getTextWidth($text2, $font, 9);
            $canvas->text(($width - $textWidth2) / 2, 45, $text2, $font, 9);

            // Texto 3 centrado
            $text3 = '“Año de la recuperación y consolidación de la economía peruana”';
            $textWidth3 = $metrics->getTextWidth($text3, $font, 8);
            $canvas->text(($width - $textWidth3) / 2, 58, $text3, $font, 8);

            // Línea horizontal
            $canvas->line(30, 70, 580, 70, [0, 0, 0], 1);
        });

        return $pdf->download('oficios_ejemplo.pdf');
    }

    public function descargarReporte_facultades(Request $request)
    {
        DB::beginTransaction();
        try {
            // Obtener todas las oficinas excepto ADMIN
            $oficinas = Oficina::whereBetween('id', [2, 13])
                ->orderBy('nombre')
                ->get();

            $reportePorOficina = [];

            foreach ($oficinas as $oficina) {
                $documentos = Documento::select('anio', 'numero', 'clase_documento_id')
                    ->where('oficina_remitente', $oficina->nombre)
                    ->where('estado_registro', 'A')
                    ->orderBy('anio', 'desc')
                    ->orderBy('numero', 'asc')
                    ->get()
                    ->groupBy(['anio', 'clase_documento_id']);

                $ultimoDocumento = Documento::where('oficina_remitente', $oficina->nombre)
                    ->where('estado_registro', 'A')
                    ->orderByDesc('created_at')
                    ->first();

                $fechaUltimo = $ultimoDocumento ? \Carbon\Carbon::parse($ultimoDocumento->created_at)->locale('es')->translatedFormat('d \d\e F \d\e\l Y') : 'Sin registros';

                $datos = [];

                foreach ($documentos as $anio => $grupos) {
                    $datos[$anio] = [
                        'resoluciones_decanales' => [
                            'numeros' => isset($grupos[1]) ? $grupos[1]->pluck('numero')->implode(', ') : '',
                            'fecha' => isset($grupos[1]) && $grupos[1]->count()
                                ? \Carbon\Carbon::parse($grupos[1]->max('created_at'))->locale('es')->translatedFormat('d \d\e F \d\e\l Y')
                                : null
                        ],
                        'resoluciones_consejo' => [
                            'numeros' => isset($grupos[2]) ? $grupos[2]->pluck('numero')->implode(', ') : '',
                            'fecha' => isset($grupos[2]) && $grupos[2]->count()
                                ? \Carbon\Carbon::parse($grupos[2]->max('created_at'))->locale('es')->translatedFormat('d \d\e F \d\e\l Y')
                                : null
                        ],
                        'actas_consejo' => [
                            'numeros' => isset($grupos[3]) ? $grupos[3]->pluck('numero')->implode(', ') : '',
                            'fecha' => isset($grupos[3]) && $grupos[3]->count()
                                ? \Carbon\Carbon::parse($grupos[3]->max('created_at'))->locale('es')->translatedFormat('d \d\e F \d\e\l Y')
                                : null
                        ]
                    ];
                }

                $reportePorOficina[] = [
                    'nombre' => $oficina->nombre,
                    'datos' => $datos,
                    'fecha_ultimo' => $fechaUltimo
                ];
            }

            // Generar PDF con múltiples tablas (una por facultad/oficina)
            $pdf = Pdf::loadView('resoluciones_facultades', [
                'reportePorOficina' => $reportePorOficina
            ])
                ->setPaper('A4', 'portrait');
            $filename = 'reporte_facultades_' . date('Ymd_His') . '.pdf';
            $filepath = storage_path('app/public/reportes/' . $filename);
            DB::commit();
            // Guardar en el servidor
            $pdf->save($filepath);

            // Descargar al usuario
            return $pdf->download($filename);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                "error" => "Error al generar el reporte: " . $e->getMessage()
            ], 500);
        }
    }
}
