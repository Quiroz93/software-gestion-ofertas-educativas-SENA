<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    protected string $disk = 'public';
    
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

        return [
            'success' => true,
            'file_path' => $filePath,
            'url' => Storage::disk($this->disk)->url($filePath),
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
            $fileData = [
                'path' => $file,
                'url' => Storage::disk($this->disk)->url($file),
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
                    $fileData['thumbnail_url'] = $fileData['url'];
                }
            } elseif ($type === 'gif') {
                // Para GIFs, siempre usar la URL original (mostrar animado)
                $fileData['thumbnail_url'] = $fileData['url'];
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
     * @return string|null (URL del thumbnail o null si error)
     */
    public function generateThumbnail(string $filePath, int $width = 200, int $height = 150): ?string
    {
        // TODO: Implement thumbnail generation with proper Intervention\Image setup
        // For now, return null - thumbnails will be implemented in future
        return null;
    }

    /**
     * Generar poster para un video
     * 
     * @param string $filePath
     * @return string|null (URL del poster o null si error)
     */
    public function generateVideoPoster(string $filePath): ?string
    {
        // TODO: Implement video poster generation with proper Intervention\Image setup
        // For now, return null - video posters will be implemented in future
        return null;
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
            'uploaded_by' => auth()->id()
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
}
