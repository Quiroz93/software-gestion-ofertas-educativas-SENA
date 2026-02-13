<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preinscrito extends Model
{
	use HasFactory;
    use SoftDeletes;

    /**
     * Tabla asociada al modelo
     */
    protected $table = 'preinscritos';

    /**
     * Atributos que pueden ser asignados en masa
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'numero_documento',
        'celular_principal',
        'celular_alternativo',
        'correo_principal',
        'correo_alternativo',
        'programa_id',
        'estado',
        'comentarios',
        'novedades',
        'tipo_novedad',
        'novedad_resuelta',
        'fecha_resolucion',
        'resuelto_por',
        'created_by',
        'updated_by',
    ];

    /**
     * Tipos de atributos
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relación: Un preinscrito pertenece a un programa
     */
    public function programa(): BelongsTo
    {
        return $this->belongsTo(Programa::class);
    }

    /**
     * Relación: Usuario que creó el registro
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación: Usuario que actualizó el registro
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relación: Usuario que resolvió la novedad
     */
    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resuelto_por');
    }

    /**
     * Obtener el nombre completo del preinscrito
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Obtener el nombre del programa en lugar del ID
     */
    public function getNombreProgramaAttribute(): string
    {
        return $this->programa?->nombre ?? 'Sin asignar';
    }

    /**
     * Obtener el número de ficha del programa
     */
    public function getNumeroFichaAttribute(): string
    {
        return $this->programa?->numero_ficha ?? '';
    }

    /**
     * Validar que el número de documento sea único (solo entre registros no eliminados)
     */
    public static function documentoExiste(string $numeroDocumento, ?int $exceptId = null): bool
    {
        $query = static::where('numero_documento', $numeroDocumento);
        
        if ($exceptId) {
            $query->where('id', '!=', $exceptId);
        }
        
        // Solo buscar en registros no eliminados
        return $query->whereNull('deleted_at')->exists();
    }

    /**
     * Obtener etiqueta de estado
     */
    public function getEtiquetaEstadoAttribute(): string
    {
        return match($this->estado) {
            'inscrito' => 'Inscrito',
            'por_inscribir' => 'Por Inscribir',
            'con_novedad' => 'Con Novedad',
            default => 'Desconocido',
        };
    }

    /**
     * Obtener etiqueta de tipo de documento
     */
    public function getEtiquetaTipoDocumentoAttribute(): string
    {
        return match($this->tipo_documento) {
            'cc' => 'Cédula de Ciudadanía',
            'ti' => 'Tarjeta de Identidad',
            'ce' => 'Cédula de Extranjería',
            'ppt' => 'Pasaporte',
            'pa' => 'Permiso de Asilo',
            'pep' => 'Permiso Especial de Permanencia',
            'nit' => 'NIT',
            default => 'Desconocido',
        };
    }

    /**
     * Obtener lista de estados disponibles
     */
    public static function getEstados(): array
    {
        return [
            'inscrito' => 'Inscrito',
            'por_inscribir' => 'Por Inscribir',
            'con_novedad' => 'Con Novedad',
        ];
    }

    /**
     * Obtener lista de tipos de documento disponibles
     */
    public static function getTiposDocumento(): array
    {
        return [
            'cc' => 'Cédula de Ciudadanía',
            'ti' => 'Tarjeta de Identidad',
            'ce' => 'Cédula de Extranjería',
            'ppt' => 'Permiso por Protección Temporal',
            'pas' => 'Pasaporte',
            'pa' => 'Permiso de Asilo',
            'pep' => 'Permiso Especial de Permanencia',
            'nit' => 'NIT',
        ];
    }

    /**
     * Obtener lista de tipos de novedades disponibles
     */
    public static function getTiposNovedades(): array
    {
        return [
            'cambio_programa' => 'Cambio de Programa',
            'cambio_contacto' => 'Cambio de Contacto',
            'error_datos' => 'Error en Datos',
            'no_comparecencia' => 'No Comparecencia',
            'cambio_ubicacion' => 'Cambio de Ubicación',
            'otra' => 'Otra',
        ];
    }

    /**
     * Obtener etiqueta del tipo de novedad
     */
    public function getEtiquetaTipoNovedadAttribute(): ?string
    {
        if (!$this->tipo_novedad) {
            return null;
        }
        
        return match($this->tipo_novedad) {
            'cambio_programa' => 'Cambio de Programa',
            'cambio_contacto' => 'Cambio de Contacto',
            'error_datos' => 'Error en Datos',
            'no_comparecencia' => 'No Comparecencia',
            'cambio_ubicacion' => 'Cambio de Ubicación',
            'otra' => 'Otra',
            default => 'Desconocido',
        };
    }

    /**
     * Scope: Filtrar por programa
     */
    public function scopeByPrograma($query, ?int $programaId)
    {
        if ($programaId) {
            return $query->where('programa_id', $programaId);
        }
        return $query;
    }

    /**
     * Scope: Filtrar por estado
     */
    public function scopeByEstado($query, ?string $estado)
    {
        if ($estado) {
            return $query->where('estado', $estado);
        }
        return $query;
    }

    /**
     * Scope: Filtrar por tipo de documento
     */
    public function scopeByTipoDocumento($query, ?string $tipoDocumento)
    {
        if ($tipoDocumento) {
            return $query->where('tipo_documento', $tipoDocumento);
        }
        return $query;
    }

    /**
     * Scope: Buscar por número de documento
     */
    public function scopeByNumeroDocumento($query, ?string $numeroDocumento)
    {
        if ($numeroDocumento) {
            return $query->where('numero_documento', 'like', "%{$numeroDocumento}%");
        }
        return $query;
    }

    /**
     * Scope: Buscar por nombre
     */
    public function scopeByNombre($query, ?string $nombre)
    {
        if ($nombre) {
            return $query->where('nombres', 'like', "%{$nombre}%")
                ->orWhere('apellidos', 'like', "%{$nombre}%");
        }
        return $query;
    }

    /**
     * Relación: Novedades del preinscrito
     */
    public function novedades()
    {
        return $this->hasMany(NovedadPreinscrito::class);
    }

    /**
     * Scope: Filtrar por tipo de novedad
     */
    public function scopeByTipoNovedad($query, ?string $tipoNovedad)
    {
        if ($tipoNovedad) {
            return $query->where('tipo_novedad', $tipoNovedad);
        }
        return $query;
    }

    /**
     * Scope: Filtrar por estado de resolución de novedad
     */
    public function scopeByNovedadResuelta($query, ?bool $resueltas = null)
    {
        if ($resueltas !== null) {
            return $query->where('novedad_resuelta', $resueltas);
        }
        return $query;
    }

    /**
     * Scope: Incluir solo preinscritos con novedades
     */
    public function scopeConNoveadesAbierta($query)
    {
        return $query->where('estado', 'con_novedad')
            ->where('novedad_resuelta', false);
    }

    /**
     * Scope: Incluir registros eliminados
     */
    public function scopeWithTrashed($query)
    {
        return $query->withTrashed();
    }
}