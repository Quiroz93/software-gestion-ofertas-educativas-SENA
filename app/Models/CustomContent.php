<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CustomContent extends Model
{
    protected $fillable = [
        'contentable_type',
        'contentable_id',
        'key',
        'value',
        'type',
        'metadata',          // ✅ NEW: JSON para metadatos
        'alt_text',          // ✅ NEW: Accesibilidad
        'title',             // ✅ NEW: Tooltip/title
    ];

    /**
     * ✅ Castear atributos a tipos específicos
     */
    protected $casts = [
        'metadata' => 'array',   // ✅ Castear JSON a array automáticamente
    ];

    /**
     * Relación polimórfica inversa
     */
    public function contentable()
    {
        return $this->morphTo();
    }

    /**
     * ✅ NEW: Obtener URL completa verificada del archivo multimedia
     * 
     * @return string|null
     */
    public function getVerifiedUrl(): ?string
    {
        // Solo aplica para multimedia
        if (!in_array($this->type, ['image', 'video', 'gif'])) {
            return null;
        }

        $path = $this->value;
        
        // Verificar que el archivo existe
        if (str_starts_with($path, 'media/')) {
            if (!Storage::disk('public')->exists($path)) {
                return null; // Archivo no existe
            }
            
            return asset('storage/' . $path);
        }

        return $this->value;
    }

    /**
     * ✅ NEW: Verificar si el archivo físico existe en storage
     * 
     * @return bool
     */
    public function fileExists(): bool
    {
        // Si no es multimedia, considerar que "existe"
        if (!in_array($this->type, ['image', 'video', 'gif'])) {
            return true;
        }

        $path = $this->value;
        
        if (str_starts_with($path, 'media/')) {
            return Storage::disk('public')->exists($path);
        }

        return false;
    }

    /**
     * ✅ NEW: Obtener un valor específico de metadata
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getMetadata(string $key, $default = null)
    {
        if (!$this->metadata || !is_array($this->metadata)) {
            return $default;
        }

        return $this->metadata[$key] ?? $default;
    }

    /**
     * ✅ NEW: Obtener alt_text con fallback
     * 
     * @param string|null $default
     * @return string|null
     */
    public function getAltText(?string $default = null): ?string
    {
        return $this->alt_text ?? $default;
    }

    /**
     * ✅ NEW: Obtener title con fallback
     * 
     * @param string|null $default
     * @return string|null
     */
    public function getTitle(?string $default = null): ?string
    {
        return $this->title ?? $default;
    }
}

