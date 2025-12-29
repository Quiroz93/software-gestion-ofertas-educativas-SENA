@extends('layouts.app')

@section('page_title', 'Bienvenido')
@section('page_subtitle', 'Sistema de Gestión de Ofertas Educativas')

@section('content_body')

{{-- Sección bienvenida --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-body text-center">
                <h4>Bienvenido al aplicativo</h4>
                <p class="text-muted mb-0">
                    Plataforma para la gestión de ofertas educativas del SENA
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Accesos rápidos --}}
<div class="row">

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-info">
            <span class="info-box-icon">
                <i class="fas fa-building"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Centros</span>
                <a href="{{ route('centro.index') }}" class="small text-white">
                    Gestionar centros
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-success">
            <span class="info-box-icon">
                <i class="fas fa-book"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Programas</span>
                <a href="#" class="small text-white">
                    Ver programas
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-warning">
            <span class="info-box-icon">
                <i class="fas fa-graduation-cap"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Ofertas</span>
                <a href="#" class="small text-white">
                    Gestionar ofertas
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="info-box bg-secondary">
            <span class="info-box-icon">
                <i class="fas fa-users"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Usuarios</span>
                <a href="#" class="small text-white">
                    Administración
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
