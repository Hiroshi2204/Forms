<?php

namespace App\Http\Controllers;

use App\Models\EgresosAdicionales;
use App\Models\Oficio;
use App\Models\Producto;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalidaDetalle;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportePDFController extends Controller
{

    public function descargarReporteEjemplo(Request $request)
    {
        $oficios = Oficio::whereMonth('fecha_envio', $request->mes ?? now()->month)->get();


        $mesNumero = $request->mes ?? now()->month;
        $nombreMes = \Carbon\Carbon::create()->month($mesNumero)->locale('es')->isoFormat('MMMM');
        $anio = now()->year;

        $pdf = Pdf::loadView('oficios_ejemplo', compact('oficios', 'nombreMes' , 'anio'));

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
}
