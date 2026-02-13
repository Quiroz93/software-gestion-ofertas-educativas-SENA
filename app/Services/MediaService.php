<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Exception;

class MediaService
{
    protected string $disk = 'public';
    protected ?ImageManager $imageManager = null;
    
    protected array $allowedImageMimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp'
    ];
    
    protected array $allowedVideoMimes = [
        'video/mp4',
        'video/webm',
        'video/ogg'
    ];

    public function __construct()
    {
        // Initialize ImageManager only if image extension is available
        try {
            if (extension_loaded('gd')) {
                $this->imageManager = new ImageManager(new GdDriver());
            } elseif (extension_loaded('imagick')) {
                $this->imageManager = new ImageManager(new \Intervention\Image\Drivers\Imagick\Driver());
            } else {
                $this->imageManager = null;
                Log::warning('Neither GD nor Imagick PHP extensions are loaded - thumbnail generation will be disabled');
            }
        } catch (\Exception $e) {
            $this->imageManager = null;
            Log::error('Failed to initialize ImageManager: ' . $e->getMessage());
        }
    }

    /**
     * Procesar upload de archivo multimedia
     * 
     * @param UploadedFile $file
     * @param string $type (image, video, gif)
     * @param string $category (ofertas, programas, general)
     * @return array
     */
    public function processUpload(UploadedFile $file, string $type, string $category): array
    {
        // 1. Validar tipo MIME real
        $this->validateMimeType($file, $type);

        // 2. Generar nombre único y seguro
        $fileName = $this->generateFileName($file);

        // 3. Determinar ruta de almacenamiento
        $path = $this->getStoragePath($type, $category);

        // 4. Almacenar archivo
        $filePath = $file->storeAs($path, $fileName, $this->disk);

        // 5. Generar metadata
        $metadata = $this->generateMetadata($file, $filePath, $type);

        // 6. Intentar generar thumbnail para imágenes (NO para GIFs)
        $thumbnailUrl = null;
        if (($type === 'image') && !str_ends_with(strtolower($file->getClientOriginalName()), '.gif')) {
            try {
                $thumbnailPath = $this->generateThumbnail($filePath);
                if ($thumbnailPath) {
                    $thumbnailUrl = Storage::disk($this->disk)->url($thumbnailPath);
                }
            } catch (Exception $e) {
                // Log error but don't fail upload
                Log::warning("Thumbnail generation failed for {$filePath}: " . $e->getMessage());
            }
        }

        $fileUrl = Storage::disk($this->disk)->url($filePath);

        return [
            'success' => true,
            'file_path' => $filePath,
            'url' => $fileUrl,
            'thumbnail_url' => $thumbnailUrl ?? $fileUrl,
            'metadata' => $metadata
        ];
    }

    /**
     * Listar archivos existentes de una categoría
     * 
     * @param string $type
     * @param string $category
     * @return array
     */
    public function listFiles(string $type, string $category): array
    {
        $path = $this->getStoragePath($type, $category);
        
        if (!Storage::disk($this->disk)->exists($path)) {
            return [];
        }

        $files = Storage::disk($this->disk)->files($path);

        return collect($files)->map(function ($file) use ($type) {
            $fileUrl = Storage::disk($this->disk)->url($file);
            
            $fileData = [
                'path' => $file,
                'url' => $fileUrl,
                'name' => basename($file),
                'size' => Storage::disk($this->disk)->size($file),
                'modified' => Storage::disk($this->disk)->lastModified($file),
                'is_gif' => strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'gif'
            ];

            // 🖼️ Agregar URL de thumbnail si existe (NO para GIFs)
            if ($type === 'image' && !$fileData['is_gif']) {
                $thumbPath = str_replace('media/', 'media/thumbnails/', $file);
                if (Storage::disk($this->disk)->exists($thumbPath)) {
                    $fileData['thumbnail_url'] = Storage::disk($this->disk)->url($thumbPath);
                } else {
                    // Si no existe thumbnail, usar imagen original como fallback
                    $fileData['thumbnail_url'] = $fileUrl;
                }
            } elseif ($type === 'gif') {
                // Para GIFs, siempre usar la URL original (mostrar animado)
                $fileData['thumbnail_url'] = $fileUrl;
            }

            return $fileData;
        })->sortByDesc('modified')->values()->toArray();
    }

    /**
     * Eliminar archivo del almacenamiento
     * 
     * @param string $filePath
     * @return bool
     */
    public function deleteFile(string $filePath): bool
    {
        // Eliminar archivo principal
        $deleted = Storage::disk($this->disk)->delete($filePath);

        // Intentar eliminar thumbnail si existe
        $thumbPath = str_replace('media/', 'media/thumbnails/', $filePath);
        if (Storage::disk($this->disk)->exists($thumbPath)) {
            Storage::disk($this->disk)->delete($thumbPath);
        }

        return $deleted;
    }

    /**
     * Generar thumbnail para una imagen
     * 
     * @param string $filePath
     * @param int $width
     * @param int $height
     * @return string|null (ruta del thumbnail o null si error)
     */
    public function generateThumbnail(string $filePath, int $width = 200, int $height = 150): ?string
    {
        // Si ImageManager no está disponible, no generar thumbnails
        if ($this->imageManager === null) {
            Log::debug('ImageManager not available - skipping thumbnail generation for ' . $filePath);
            return null;
        }

        try {
            $fullPath = Storage::disk($this->disk)->path($filePath);
            
            // Si el archivo no existe, retornar null
            if (!file_exists($fullPath)) {
                Log::error("Archivo para thumbnail no existe: {$fullPath}");
                return null;
            }

            // Leer imagen con Intervention
            $image = $this->imageManager->read($fullPath);

            // Aplicar cover (crop desde el centro)
            $image->cover($width, $height, 'center');

            // Generar ruta para el thumbnail
            $thumbnailPath = $this->getThumbnailPath($filePath);
            
            // Crear directorio si no existe
            $thumbnailDir = dirname(Storage::disk($this->disk)->path($thumbnailPath));
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }

            // Guardar thumbnail con calidad 85
            $fullThumbPath = Storage::disk($this->disk)->path($thumbnailPath);
            $image->save($fullThumbPath, 85);

            Log::info("Thumbnail generado exitosamente: {$thumbnailPath}");
            
            return $thumbnailPath;
        } catch (Exception $e) {
            Log::error("Error generating thumbnail for {$filePath}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Generar poster para un video
     * 
     * @param string $filePath
     * @return string|null (ruta del poster o null si error)
     */
    public function generateVideoPoster(string $filePath): ?string
    {
        // Si ImageManager no está disponible, no generar posters
        if ($this->imageManager === null) {
            Log::debug('ImageManager not available - skipping poster generation for ' . $filePath);
            return null;
        }

        try {
            // Crear una imagen genérica de poster (320x180px)
            $poster = $this->imageManager->create(320, 180)->fill('222222');

            // Agregar un círculo de play (blanco) en el centro
            $poster->circle(
                radius: 40,
                x: 160,
                y: 90,
                closure: function ($circle) {
                    $circle->background('ffffff');
                }
            );

            // Agregar triángulo de play (simulado con líneas)
            // Crear un ícono simple de play
            $poster->text('▶', 155, 85, closure: function ($text) {
                $text->size(48)->color('222222')->align('center');
            });

            // Generar ruta para el poster
            $posterPath = $this->getPosterPath($filePath);
            
            // Crear directorio si no existe
            $posterDir = dirname(Storage::disk($this->disk)->path($posterPath));
            if (!is_dir($posterDir)) {
                mkdir($posterDir, 0755, true);
            }

            // Guardar poster
            $fullPosterPath = Storage::disk($this->disk)->path($posterPath);
            $poster->save($fullPosterPath, 85);

            Log::info("Video poster generado exitosamente: {$posterPath}");
            
            return $posterPath;
        } catch (Exception $e) {
            Log::error("Error generating video poster for {$filePath}: " . $e->getMessage());
            return null;
        }
    }

    // ============ Métodos Privados ============

    /**
     * Validar que el MIME type sea permitido
     * 
     * @param UploadedFile $file
     * @param string $type
     * @throws \InvalidArgumentException
     */
    private function validateMimeType(UploadedFile $file, string $type): void
    {
        $mime = $file->getMimeType();
        
        $allowed = match($type) {
            'image', 'gif' => $this->allowedImageMimes,
            'video' => $this->allowedVideoMimes,
            default => []
        };

        if (!in_array($mime, $allowed)) {
            throw new \InvalidArgumentException("Tipo de archivo no permitido: {$mime}");
        }

        // Validación adicional: verificar MIME real del archivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMime = finfo_file($finfo, $file->getRealPath());
        finfo_close($finfo);

        if ($realMime !== $mime) {
            throw new \InvalidArgumentException("El archivo no coincide con su tipo declarado");
        }
    }

    /**
     * Generar nombre único y seguro para el archivo
     * 
     * @param UploadedFile $file
     * @return string
     */
    private function generateFileName(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        // Validar que la extensión no sea peligrosa
        $forbidden = ['php', 'phtml', 'php3', 'php4', 'php5', 'phar', 'exe', 'sh'];
        if (in_array($extension, $forbidden)) {
            throw new \InvalidArgumentException("Tipo de archivo prohibido");
        }

        $baseName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $unique = Str::random(8);
        
        return "{$baseName}-{$unique}.{$extension}";
    }

    /**
     * Obtener ruta de almacenamiento según tipo y categoría
     * 
     * @param string $type
     * @param string $category
     * @return string
     */
    private function getStoragePath(string $type, string $category): string
    {
        // Validar que category no contenga path traversal
        if (preg_match('/\.\./', $category)) {
            throw new \InvalidArgumentException('Categoría inválida');
        }

        // Sanitizar categoría
        $category = Str::slug($category);

        return match($type) {
            'image', 'gif' => "media/images/{$category}",
            'video' => "media/videos/{$category}",
            default => "media/general/{$category}"
        };
    }

    /**
     * Generar metadata del archivo
     * 
     * @param UploadedFile $file
     * @param string $filePath
     * @param string $type
     * @return array
     */
    private function generateMetadata(UploadedFile $file, string $filePath, string $type): array
    {
        $metadata = [
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'uploaded_at' => now()->toISOString(),
            'uploaded_by' => auth()->check() ? auth()->id() : null
        ];

        // Agregar dimensiones para imágenes
        if ($type === 'image' || $type === 'gif') {
            $fullPath = Storage::disk($this->disk)->path($filePath);
            
            if (file_exists($fullPath)) {
                $imageInfo = getimagesize($fullPath);
                if ($imageInfo !== false) {
                    [$width, $height] = $imageInfo;
                    $metadata['dimensions'] = compact('width', 'height');
                }
            }
        }

        return $metadata;
    }

    /**
     * Obtener ruta del thumbnail para un archivo de imagen
     * 
     * @param string $filePath
     * @return string
     */
    private function getThumbnailPath(string $filePath): string
    {
        // Reemplazar "media/images/" con "media/images/thumbnails/"
        $parts = explode('/', $filePath);
        array_splice($parts, -1, 0, 'thumbnails');
        return implode('/', $parts);
    }

    /**
     * Obtener ruta del poster para un archivo de video
     * 
     * @param string $filePath
     * @return string
     */
    private function getPosterPath(string $filePath): string
    {
        // Reemplazar "media/videos/" con "media/videos/posters/"
        // y cambiar extensión a .png
        $parts = explode('/', $filePath);
        $filename = array_pop($parts);
        $filename = pathinfo($filename, PATHINFO_FILENAME) . '.png';
        array_splice($parts, -1, 0, 'posters');
        $parts[] = $filename;
        return implode('/', $parts);
    }
}
