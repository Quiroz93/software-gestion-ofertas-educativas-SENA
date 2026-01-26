<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\CustomContent;

class MediaCleanupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:cleanup {--delete : Eliminar archivos huérfanos}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Encontrar y limpiar archivos multimedia sin referencia en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Escaneando archivos multimedia...');

        $disk = 'public';
        $mediaPath = 'media';

        // Obtener todos los archivos en storage/media
        $allFiles = $this->getAllMediaFiles($mediaPath, $disk);
        $this->line("📦 Total de archivos encontrados: " . count($allFiles));

        // Obtener rutas referenciadas en custom_contents
        $referencedPaths = $this->getReferencedPaths();
        $this->line("📋 Archivos referenciados en BD: " . count($referencedPaths));

        // Encontrar huérfanos
        $orphanFiles = array_diff($allFiles, $referencedPaths);
        $this->line("🗑️ Archivos sin referencia: " . count($orphanFiles));

        if (empty($orphanFiles)) {
            $this->info("✅ No hay archivos huérfanos");
            return 0;
        }

        // Mostrar archivos huérfanos
        $this->line("\n📂 Archivos a eliminar:");
        foreach ($orphanFiles as $file) {
            $fileSize = Storage::disk($disk)->size($file);
            $this->line("  - " . $file . " (" . $this->formatBytes($fileSize) . ")");
        }

        // Confirmar antes de eliminar
        if ($this->option('delete')) {
            if (!$this->confirm('\n¿Continuar con la eliminación?')) {
                $this->info('❌ Operación cancelada');
                return 0;
            }

            $deletedCount = 0;
            $totalSize = 0;

            foreach ($orphanFiles as $file) {
                try {
                    $fileSize = Storage::disk($disk)->size($file);
                    Storage::disk($disk)->delete($file);
                    $deletedCount++;
                    $totalSize += $fileSize;
                    $this->line("✓ Eliminado: " . $file);
                } catch (\Exception $e) {
                    $this->warn("✗ Error al eliminar {$file}: " . $e->getMessage());
                }
            }

            $this->info("\n✅ Limpieza completada");
            $this->line("📊 Archivos eliminados: {$deletedCount}");
            $this->line("💾 Espacio liberado: " . $this->formatBytes($totalSize));

            return 0;
        } else {
            $totalSize = 0;
            foreach ($orphanFiles as $file) {
                $totalSize += Storage::disk($disk)->size($file);
            }

            $this->info("\n💡 Ejecuta con --delete para eliminar estos archivos");
            $this->line("   Espacio que se liberaría: " . $this->formatBytes($totalSize));
            $this->line("   php artisan media:cleanup --delete");

            return 0;
        }
    }

    /**
     * Obtener todos los archivos en media
     */
    private function getAllMediaFiles(string $path, string $disk): array
    {
        $files = [];
        $directories = [
            'media/images/general',
            'media/images/ofertas',
            'media/images/programas',
            'media/videos/ofertas',
            'media/videos/programas',
            'media/thumbnails',
            'media/posters',
        ];

        foreach ($directories as $dir) {
            if (Storage::disk($disk)->exists($dir)) {
                $dirFiles = Storage::disk($disk)->files($dir);
                $files = array_merge($files, $dirFiles);
            }
        }

        return $files;
    }

    /**
     * Obtener rutas referenciadas en custom_contents
     */
    private function getReferencedPaths(): array
    {
        $contents = CustomContent::where('type', 'in', ['image', 'video', 'gif'])
            ->get(['value', 'metadata']);

        $paths = [];

        foreach ($contents as $content) {
            // El valor puede contener la ruta del archivo
            if (!empty($content->value) && strpos($content->value, 'media/') !== false) {
                $paths[] = $content->value;
            }

            // Revisar metadata para rutas de archivos
            if (!empty($content->metadata)) {
                $metadata = is_array($content->metadata) ? $content->metadata : json_decode($content->metadata, true);
                if (isset($metadata['file_path'])) {
                    $paths[] = $metadata['file_path'];
                }

                // También buscar thumbnails y posters relacionados
                if (isset($metadata['file_path'])) {
                    $basePath = $metadata['file_path'];
                    $thumbPath = str_replace('media/', 'media/thumbnails/', $basePath);
                    $posterPath = str_replace(['media/videos/', '.mp4', '.webm', '.ogv'], 
                                              ['media/posters/', '.jpg', '.jpg', '.jpg'], $basePath);
                    $paths[] = $thumbPath;
                    $paths[] = $posterPath;
                }
            }
        }

        return array_unique(array_filter($paths));
    }

    /**
     * Formatear bytes a formato legible
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
