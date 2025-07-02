<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Convertir_PDF extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Ajusta el signature para pasar la ruta base como argumento
     */
    protected $signature = 'convert:convertir-pdf {path : Ruta base de la carpeta SG}';

    /**
     * The console command description.
     */
    protected $description = 'Convierte recursivamente todos los archivos Word (.doc y .docx) a PDF en el mismo directorio, eliminando el original y generando un log';

    /**
     * LibreOffice ejecutable (ajusta si tu ruta es diferente)
     */
    protected $libreOfficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';

    /**
     * Log file path
     */
    protected $logFile;

    protected $logHandle;

    public function handle()
    {
        $baseDir = $this->argument('path');
        if (!is_dir($baseDir)) {
            $this->error("❌ La ruta especificada no existe o no es un directorio: $baseDir");
            return 1;
        }

        $this->logFile = storage_path('logs/conversion_log.txt');

        $this->logHandle = fopen($this->logFile, 'a');
        if (!$this->logHandle) {
            $this->error("❌ No se pudo abrir el archivo de log: {$this->logFile}");
            return 1;
        }

        $this->logMessage("===== INICIO DE CONVERSIÓN =====");
        $this->logMessage("Directorio base: $baseDir");

        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($baseDir));

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            $filePath = $file->getPathname();
            $extension = strtolower($file->getExtension());

            if ($extension === 'doc' || $extension === 'docx') {
                $this->convertFile($filePath);
            }
        }

        $this->logMessage("===== FIN DE CONVERSIÓN =====");

        fclose($this->logHandle);
        $this->info("✅ Conversión completada. Revisa el log en: {$this->logFile}");
        return 0;
    }

    protected function convertFile($filePath)
    {
        $dir = escapeshellarg(dirname($filePath));
        $inputFile = escapeshellarg($filePath);

        $this->logMessage("Convirtiendo: $filePath");

        $cmd = "{$this->libreOfficePath} --headless --convert-to pdf $inputFile --outdir $dir";

        exec($cmd, $output, $returnVar);

        if ($returnVar === 0) {
            $this->logMessage("✅ Conversión exitosa: $filePath");

            if (unlink($filePath)) {
                $this->logMessage("🗑️ Archivo original eliminado: $filePath");
            } else {
                $this->logMessage("⚠️ No se pudo eliminar el archivo: $filePath");
            }
        } else {
            $this->logMessage("❌ Error al convertir: $filePath");
        }
    }

    protected function logMessage($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        fwrite($this->logHandle, "[$timestamp] $message\n");
        $this->line("[$timestamp] $message");
    }
}