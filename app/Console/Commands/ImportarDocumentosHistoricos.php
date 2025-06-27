<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\{Documento, Oficina, ClaseDocumento, OficinaDocumento};
use Carbon\Carbon;
use Symfony\Component\Finder\Finder;
use Illuminate\Http\File;

class ImportarDocumentosHistoricos extends Command
{
    protected $signature = 'documentos:import
                            {path : Ruta absoluta a la carpeta "facultades"}
                            {--dry-run : Simula sin escribir en BD ni mover archivos}';

    protected $description = 'Importa PDFs históricos de resoluciones por facultad (dry‏‑run disponible).';

    public function handle(): int
    {
        $dryRun   = (bool) $this->option('dry-run');
        $basePath = rtrim($this->argument('path'), DIRECTORY_SEPARATOR);
        $start    = microtime(true);

        // Catálogos
        $oficinas = Oficina::pluck('id', 'nomenclatura')->mapWithKeys(fn($id, $key) => [strtolower($key) => $id]);
        $clasesPorNomen = ClaseDocumento::pluck('id', 'nomenclatura')->mapWithKeys(fn($id, $key) => [strtolower($key) => $id]);
        $clasesPorNombre = ClaseDocumento::all()->mapWithKeys(fn($row) => [$this->slug($row->nombre) => $row->id]);

        $resolveClase = function (string $folder) use ($clasesPorNomen, $clasesPorNombre): ?int {
            $byNomen = strtolower($folder);
            return $clasesPorNomen[$byNomen]
                ?? $clasesPorNombre[$this->slug($folder)]
                ?? null;
        };

        // Finder
        $finder = (new Finder())->files()->in($basePath)->name('*.pdf');
        $total  = iterator_count($finder);
        if (!$total) {
            $this->warn('No se encontraron PDFs en la ruta indicada.');
            return self::SUCCESS;
        }
        $this->info("Total de PDFs encontrados: {$total}");
        if ($dryRun) $this->warn('DRY‑RUN activado: se simula la importación.');

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $importados = $duplicados = $saltados = $errores = 0;

        foreach ($finder as $file) {
            /** @var \Symfony\Component\Finder\SplFileInfo \$file */
            $relativeDir = $file->getRelativePath();
            $segments    = preg_split('#[\\\/]#', $relativeDir);

            if (count($segments) < 3) {
                ++$saltados;
                $msg = "estructura de carpetas insuficiente ({$relativeDir})";
                $this->warn("Saltando {$file->getRelativePathname()}: {$msg}");
                Log::warning('[ImportHist] ' . $msg, ['archivo' => $file->getRealPath()]);
                $bar->advance();
                continue;
            }

            [$facRaw, $tipoRaw, $anioRaw] = array_slice($segments, 0, 3);
            $fac  = strtolower(trim($facRaw));
            $tipo = trim($tipoRaw);
            $anio = trim($anioRaw);

            // Oficina
            $oficina_id = $oficinas[$fac] ?? null;
            // ClaseDocumento
            $clase_documento_id = $resolveClase($tipo);

            $relacionValida = ($oficina_id && $clase_documento_id) &&
                OficinaDocumento::where('oficina_id', $oficina_id)
                ->where('clase_documento_id', $clase_documento_id)
                ->exists();

            $razones = [];
            if (!$oficina_id)         $razones[] = "oficina '{$fac}' no encontrada";
            if (!$clase_documento_id) $razones[] = "tipo '{$tipo}' no encontrado";
            if ($oficina_id && $clase_documento_id && !$relacionValida)
                $razones[] = 'combinación oficina‑tipo no permitida';

            if ($razones) {
                ++$saltados;
                $this->warn("Saltando {$file->getRelativePathname()}: " . implode('; ', $razones));
                Log::warning('[ImportHist] ' . implode('; ', $razones), ['archivo' => $file->getRealPath()]);
                $bar->advance();
                continue;
            }

            $maxNumero = Documento::where('oficina_id', $oficina_id)
                ->where('clase_documento_id', $clase_documento_id)
                ->where('anio', $anio)
                ->max('numero');
            $numeroInt        = ($maxNumero ? (int) $maxNumero : 0) + 1;
            $numeroFormateado = str_pad($numeroInt, 4, '0', STR_PAD_LEFT);

            $claseNomen = strtolower(ClaseDocumento::find($clase_documento_id)->nomenclatura);
            $num_anio   = strtoupper("\{$numeroFormateado}-\{$anio}-\{$claseNomen}-\{$fac}");

            if (Documento::where('num_anio', $num_anio)->exists()) {
                ++$duplicados;
                $this->warn("Duplicado {\$file->getRelativePathname()} (num_anio {\$num_anio})");
                Log::notice('[ImportHist] duplicado', ['num_anio' => $num_anio, 'archivo' => $file->getRealPath()]);
                $bar->advance();
                continue;
            }

            DB::beginTransaction();
            try {
                $destRelative = "documentos/{\$anio}/{\$fac}/{\$claseNomen}/" . $file->getFilename();

                if (!$dryRun) {
                    Storage::disk('public')->put(
                        $destRelative,
                        file_get_contents($file->getRealPath())
                    );
                }

                if (!$dryRun) {
                    Documento::create([
                        'nombre'              => $file->getFilename(),
                        'numero'              => $numeroFormateado,
                        'anio'                => $anio,
                        'num_anio'            => $num_anio,
                        'resumen'             => 'IMPORTADO HISTÓRICO',
                        'detalle'             => '',
                        'fecha_doc'           => Carbon::create($anio, 1, 1),
                        'fecha_envio'         => now(),
                        'oficina_remitente'   => strtoupper($fac),
                        'oficina_id'          => $oficina_id,
                        'clase_documento_id'  => $clase_documento_id,
                        'pdf_path'            => $destRelative,
                        'nombre_original_pdf' => $file->getFilename(),
                        'estado_registro'     => 'A',
                        'oficio_id'           => null,
                    ]);
                }

                DB::commit();
                ++$importados;
            } catch (\Throwable $e) {
                DB::rollBack();
                ++$errores;
                $this->error("Error en {\$file->getRelativePathname()}: " . $e->getMessage());
                Log::error('[ImportHist] excepcion', ['archivo' => $file->getRealPath(), 'msg' => $e->getMessage()]);
            }

            $bar->advance();
        }

        $bar->finish();
        $elapsed = round(microtime(true) - $start, 2);
        $this->newLine(2);
        $this->table(['Importados', 'Duplicados', 'Saltados', 'Errores', 'Tiempo (s)'], [[
            $importados, $duplicados, $saltados, $errores, $elapsed
        ]]);

        $this->info('Proceso completado. Revisa storage/logs/laravel.log para más detalles.');
        return self::SUCCESS;
    }

    private function slug(string $text): string
    {
        $text = strtolower(trim($text));
        $text = str_replace([
            'á','é','í','ó','ú','ñ','ü','à','è','ì','ò','ù'
        ], [
            'a','e','i','o','u','n','u','a','e','i','o','u'
        ], $text);
        return preg_replace('/[^a-z0-9]+/','', $text);
    }
}
