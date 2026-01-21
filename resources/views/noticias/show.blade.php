@extends('layouts.app')

@section('title', 'Detalle de Noticia')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-newspaper text-primary"></i>
        Detalle de Noticia
    </h1>

    <a href="{{ route('noticias.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i>
        Volver
    </a>
</div>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <div class="card card-outline card-primary shadow-sm">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title fw-bold">
                        {{ $noticia->titulo }}
                    </h3>
                    <div class="card-tools">
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
                </div>

                {{-- IMAGEN --}}
                @if($noticia->imagen)
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" 
                         class="card-img-top" 
                         alt="{{ $noticia->titulo }}"
                         style="max-height: 400px; object-fit: cover;">
                @endif

                {{-- BODY --}}
                <div class="card-body">

                    {{-- Descripción --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-align-left"></i>
                            Descripción
                        </h5>
                        <p class="text-muted ms-4" style="white-space: pre-line;">
                            {{ $noticia->descripcion }}
                        </p>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-info-circle"></i>
                            Información adicional
                        </h5>
                        <p class="text-muted ms-4">
                            <strong>Fecha de publicación:</strong> {{ $noticia->created_at->format('d/m/Y H:i') }}<br>
                            <strong>Última actualización:</strong> {{ $noticia->updated_at->format('d/m/Y H:i') }}<br>
                            <strong>Estado:</strong> 
                            @if($noticia->activa)
                                <span class="badge bg-success">Activa</span>
                            @else
                                <span class="badge bg-secondary">Inactiva</span>
                            @endif
                        </p>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('noticias.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Volver al listado
                        </a>

                        <div>
                            @can('noticias.update')
                                <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                            @endcan

                            @can('noticias.delete')
                                <form action="{{ route('noticias.destroy', $noticia) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta noticia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
