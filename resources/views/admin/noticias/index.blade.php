@extends('layouts.admin')

@php use Illuminate\Support\Str; @endphp

@section('title', 'Noticias')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-newspaper text-primary"></i>
        Gestión de Noticias
    </h1>

    <div>
        @can('noticias.create')
            <a href="{{ route('noticias.create') }}" class="btn btn-outline-success">
                <i class="fas fa-plus-circle"></i>
                Crear noticia
            </a>
        @endcan
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@endsection

@section('content')

<div class="container-fluid">

    @if($noticias->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            No existen noticias registradas.
        </div>
    @else

        <div class="row">
            @foreach($noticias as $noticia)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card card-outline card-primary h-100">
                    
                    {{-- Imagen --}}
                    @if($noticia->imagen)
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" 
                             class="card-img-top" 
                             alt="{{ $noticia->titulo }}"
                             style="max-height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif

                    {{-- Header --}}
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            {{ $noticia->titulo }}
                        </h5>
                    </div>

                    {{-- Body --}}
                    <div class="card-body">
                        <p class="card-text text-muted">
                            {{ $noticia->descripcion_corta }}
                        </p>

                        <div class="mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-active" 
                                       type="checkbox" 
                                       role="switch" 
                                       data-noticia-id="{{ $noticia->id }}"
                                       {{ $noticia->activa ? 'checked' : '' }}
                                       @cannot('noticias.update') disabled @endcannot>
                                <label class="form-check-label">
                                    <span class="badge {{ $noticia->activa ? 'bg-success' : 'bg-secondary' }}">
                                        <i class="fas fa-{{ $noticia->activa ? 'check' : 'times' }}"></i> 
                                        {{ $noticia->activa ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="text-muted small mt-2">
                            <i class="fas fa-calendar"></i>
                            {{ $noticia->created_at->format('d/m/Y') }}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            @can('noticias.view')
                                <a href="{{ route('noticias.show', $noticia) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            @endcan

                            <div>
                                @can('noticias.update')
                                    <a href="{{ route('noticias.edit', $noticia) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('noticias.delete')
                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-delete-noticia"
                                            data-noticia-id="{{ $noticia->id }}"
                                            data-noticia-titulo="{{ $noticia->titulo }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <form id="delete-form-{{ $noticia->id }}" 
                                          action="{{ route('noticias.destroy', $noticia) }}" 
                                          method="POST" 
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

    @endif

</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Toggle Active/Inactive
    document.querySelectorAll('.toggle-active').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const noticiaId = this.dataset.noticiaId;
            const checkbox = this;
            const badge = this.parentElement.querySelector('.badge');
            const icon = badge.querySelector('i');
            
            fetch(`/noticias/${noticiaId}/toggle-active`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Actualizar UI
                    if (data.activa) {
                        badge.classList.remove('bg-secondary');
                        badge.classList.add('bg-success');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-check');
                        badge.innerHTML = '<i class="fas fa-check"></i> Activa';
                    } else {
                        badge.classList.remove('bg-success');
                        badge.classList.add('bg-secondary');
                        icon.classList.remove('fa-check');
                        icon.classList.add('fa-times');
                        badge.innerHTML = '<i class="fas fa-times"></i> Inactiva';
                    }
                    
                    // Mostrar notificación
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el estado'
                });
            });
        });
    });

    // Delete Noticia
    document.querySelectorAll('.btn-delete-noticia').forEach(btn => {
        btn.addEventListener('click', function() {
            const noticiaId = this.dataset.noticiaId;
            const noticiaTitulo = this.dataset.noticiaTitulo;
            
            Swal.fire({
                title: '¿Estás seguro?',
                html: `¿Deseas eliminar la noticia:<br><strong>${noticiaTitulo}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${noticiaId}`).submit();
                }
            });
        });
    });

    // Mensaje de éxito desde session
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session("success") }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
});
</script>
@endpush