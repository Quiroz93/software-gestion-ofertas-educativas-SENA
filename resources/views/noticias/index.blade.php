@extends('layouts.app')

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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                            {{ Str::limit($noticia->descripcion, 120) }}
                        </p>

                        <div class="mt-3">
                            @if($noticia->activa)
                                <span class="badge bg-success">
                                    <i class="fas fa-check"></i> Activa
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times"></i> Inactiva
                                </span>
                            @endif
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
                                    <form action="{{ route('noticias.destroy', $noticia) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta noticia?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
