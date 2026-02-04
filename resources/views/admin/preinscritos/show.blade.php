@extends('layouts.admin')

@section('title', 'Ver Preinscrito')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-eye text-primary"></i>
        Detalles del Preinscrito: {{ $presrito->nombre_completo }}
    </h1>
    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Card Datos Personales -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Información Personal
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nombres</label>
                            <p class="h5">{{ $presrito->nombres }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Apellidos</label>
                            <p class="h5">{{ $presrito->apellidos }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Documento de Identidad -->
            <div class="card card-outline card-info mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-id-card"></i>
                        Documento de Identidad
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Tipo de Documento</label>
                            <p class="h5">
                                <span class="badge bg-light text-dark">
                                    {{ strtoupper($presrito->tipo_documento) }}
                                </span>
                                {{ $presrito->etiqueta_tipo_documento }}
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Número de Documento</label>
                            <p class="h5">{{ $presrito->numero_documento }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Información de Contacto -->
            <div class="card card-outline card-success mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-phone"></i>
                        Información de Contacto
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Celular Principal</label>
                            <p class="h5">
                                <a href="tel:{{ $presrito->celular_principal }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-phone"></i>
                                    {{ $presrito->celular_principal }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Celular Alternativo</label>
                            <p class="h5">
                                @if($presrito->celular_alternativo)
                                    <a href="tel:{{ $presrito->celular_alternativo }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-phone"></i>
                                        {{ $presrito->celular_alternativo }}
                                    </a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Correo Principal</label>
                            <p class="h5">
                                <a href="mailto:{{ $presrito->correo_principal }}" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-envelope"></i>
                                    {{ $presrito->correo_principal }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Correo Alternativo</label>
                            <p class="h5">
                                @if($presrito->correo_alternativo)
                                    <a href="mailto:{{ $presrito->correo_alternativo }}" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-envelope"></i>
                                        {{ $presrito->correo_alternativo }}
                                    </a>
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Información de Formación -->
            <div class="card card-outline card-warning mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-graduation-cap"></i>
                        Información de Formación
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Programa</label>
                            <p class="h5">{{ $presrito->programa->nombre ?? 'Sin asignar' }}</p>
                            <small class="text-muted">Ficha: {{ $presrito->programa->numero_ficha ?? 'N/A' }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Estado</label>
                            <p class="h5">
                                <span class="badge bg-{{ $presrito->estado === 'inscrito' ? 'success' : ($presrito->estado === 'por_inscribir' ? 'warning' : 'danger') }}">
                                    {{ $presrito->etiqueta_estado }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Comentarios -->
            @if($presrito->comentarios)
                <div class="card card-outline card-secondary mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sticky-note"></i>
                            Comentarios
                        </h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $presrito->comentarios }}</p>
                    </div>
                </div>
            @endif

            <!-- Card Auditoría -->
            <div class="card card-outline card-secondary mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i>
                        Información de Auditoría
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Creado</label>
                            <p class="h6">
                                {{ $presrito->created_at->format('d/m/Y H:i:s') }}
                                @if($presrito->createdBy)
                                    <br>
                                    <small class="text-muted">Por: {{ $presrito->createdBy->name }}</small>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Última Actualización</label>
                            <p class="h6">
                                {{ $presrito->updated_at->format('d/m/Y H:i:s') }}
                                @if($presrito->updatedBy)
                                    <br>
                                    <small class="text-muted">Por: {{ $presrito->updatedBy->name }}</small>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Novedades Asociadas -->
            @can('preinscritos.novedades.admin')
            <div class="card card-outline card-danger mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Novedades Asociadas
                    </h3>
                    <a href="{{ route('novedades.create') }}?preinscrito_id={{ $presrito->id }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus"></i>
                        Nueva Novedad
                    </a>
                </div>
                <div class="card-body">
                    @if($presrito->novedades && $presrito->novedades->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($presrito->novedades->sortByDesc('created_at') as $novedad)
                                        <tr>
                                            <td>
                                                @if($novedad->tipoNovedad)
                                                    <span class="badge bg-info">{{ $novedad->tipoNovedad->nombre }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Sin tipo</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $estadoClasses = [
                                                        'abierta' => 'danger',
                                                        'en_gestion' => 'warning',
                                                        'resuelta' => 'success',
                                                        'cancelada' => 'secondary'
                                                    ];
                                                    $estadoClass = $estadoClasses[$novedad->estado] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $estadoClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $novedad->estado)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ Str::limit($novedad->descripcion, 50) }}</small>
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $novedad->created_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('novedades.show', $novedad->id) }}" class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('novedades.por-preinscrito', $presrito->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-list"></i>
                                Ver todas las novedades ({{ $presrito->novedades->count() }})
                            </a>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i>
                            No hay novedades registradas para este preinscrito.
                        </div>
                    @endif
                </div>
            </div>
            @endcan

            <!-- Botones de Acción -->
            <div class="card card-outline card-light">
                <div class="card-footer">
                    @can('preinscritos.edit')
                        <a href="{{ route('preinscritos.edit', $presrito->id) }}" class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i>
                            Editar
                        </a>
                    @endcan
                    @can('preinscritos.delete')
                        <form action="{{ route('preinscritos.destroy', $presrito->id) }}" 
                              method="POST" 
                              style="display: inline-block;"
                              onsubmit="return confirmarEliminacion(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                    @endcan
                    <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmarEliminacion(event) {
        event.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar este preinscrito? Se eliminará de forma temporal.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }
</script>
@endsection
