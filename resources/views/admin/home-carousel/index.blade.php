@extends('layouts.bootstrap')

@section('title', 'Carousel del Home')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-images text-sena"></i> Gestión de Carousel
            </h1>
            <p class="text-muted mb-0">Administra los slides del carousel del home institucional</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.home-carousel.create') }}" class="btn btn-sena">
                <i class="bi bi-plus-lg"></i> Crear nuevo slide
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Mensajes de sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> 
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> 
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Sin slides --}}
    @if($slides->isEmpty())
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-info-circle display-6 text-info mb-3 d-block"></i>
            <p class="mb-0">No existen slides registrados.</p>
            <p class="text-muted small mb-3">Comienza creando el primer slide para tu carousel.</p>
            <a href="{{ route('admin.home-carousel.create') }}" class="btn btn-sena btn-sm">
                <i class="bi bi-plus-lg"></i> Crear primer slide
            </a>
        </div>
    @else
        {{-- Tabla de slides --}}
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" style="width: 5%">
                                <i class="bi bi-hash text-muted"></i>
                            </th>
                            <th style="width: 15%">Imagen</th>
                            <th style="width: 30%">Título</th>
                            <th style="width: 20%" class="text-center">Estado</th>
                            <th style="width: 15%" class="text-center">Orden</th>
                            <th style="width: 15%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($slides as $slide)
                            <tr>
                                {{-- ID --}}
                                <td class="ps-4 text-muted small">{{ $slide->id }}</td>

                                {{-- Imagen --}}
                                <td>
                                    @if($slide->image_path)
                                        <img src="{{ asset('storage/' . $slide->image_path) }}" 
                                             alt="{{ $slide->title }}"
                                             class="img-thumbnail"
                                             style="max-width: 80px; max-height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                             style="width: 80px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Título --}}
                                <td>
                                    <strong>{{ $slide->title }}</strong>
                                    @if($slide->description)
                                        <br>
                                        <small class="text-muted">
                                            {{ Str::limit($slide->description, 60) }}
                                        </small>
                                    @endif
                                </td>

                                {{-- Estado activo/inactivo con toggle --}}
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input toggle-active-slide" 
                                               type="checkbox" 
                                               id="toggle-{{ $slide->id }}"
                                               data-slide-id="{{ $slide->id }}"
                                               {{ $slide->is_active ? 'checked' : '' }}>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $slide->is_active ? '✓ Activo' : '✗ Inactivo' }}
                                    </small>
                                </td>

                                {{-- Posición --}}
                                <td class="text-center">
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-arrow-down-up"></i> {{ $slide->position }}
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.home-carousel.edit', $slide) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Editar slide">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger delete-btn"
                                                data-slide-id="{{ $slide->id }}"
                                                data-slide-title="{{ $slide->title }}"
                                                title="Eliminar slide">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No hay slides disponibles
                                </td>
                            </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Formulario oculto para eliminar --}}
        <form id="deleteForm" method="POST" action="" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif
</div>

@push('scripts')
<script>
    // Toggle de estado activo/inactivo
    document.querySelectorAll('.toggle-active-slide').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const slideId = this.dataset.slideId;
            const url = `{{ route('admin.home-carousel.toggle-active', ['homeCarousel' => ':id']) }}`.replace(':id', slideId);
            
            try {
                const response = await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();
                
                if (data.success) {
                    // Actualizar badge de estado
                    const checkbox = this;
                    const statusBadge = checkbox.closest('td').querySelector('small');
                    statusBadge.textContent = data.is_active ? '✓ Activo' : '✗ Inactivo';
                } else {
                    // Revertir el toggle si falla
                    this.checked = !this.checked;
                    alert('Error al actualizar el estado del slide');
                }
            } catch (error) {
                console.error('Error:', error);
                this.checked = !this.checked;
                alert('Error de conexión al actualizar el estado');
            }
        });
    });

    // Manejador para botones de eliminar
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const slideId = this.dataset.slideId;
            const slideTitle = this.dataset.slideTitle;
            confirmDelete(slideId, slideTitle);
        });
    });

    // Función para confirmar eliminación
    function confirmDelete(slideId, slideTitle) {
        if (confirm(`¿Estás seguro de que deseas eliminar el slide "${slideTitle}"?\n\nEsta acción no se puede deshacer.`)) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('admin.home-carousel.destroy', ['homeCarousel' => ':id']) }}`.replace(':id', slideId);
            form.submit();
        }
    }
</script>
@endpush
@endsection
