@extends('layouts.admin')

@section('title', 'Panel de control')

@section('content_header') <h1 class="m-0">Panel de Administración</h1>
@stop

@section('content')

@hasanyrole('admin | SuperAdmin')

<div class="alert alert-info alert-dismissible mb-3">
    <strong>
        {{ __('Bienvenido, :name', ['name' => auth()->user()->name]) }}
    </strong>
    <div class="small">
        {{ __('Acceso administrativo') }}
    </div>
</div>
@endhasanyrole

<div class="container-fluid">
    <div class="row">

    {{-- Preinscritos --}}
    @can('preinscritos.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-user-check fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Preinscritos</h5>
                <a href="{{ route('preinscritos.index') }}" class="btn btn-outline-success btn-sm mt-3">
                    Gestionar preinscritos
                </a>
                <a href="{{ route('preinscritos.reportes') }}" class="btn btn-outline-info btn-sm mt-3 ms-2">
                    Reportes
                </a>
                <a href="{{ route('preinscritos.historial-exportaciones') }}" class="btn btn-outline-secondary btn-sm mt-3 ms-2">
                    Historial de exportaciones
                </a>
                <a href="{{ route('preinscritos.consolidaciones.index') }}" class="btn btn-outline-primary btn-sm mt-3 ms-2">
                    Consolidaciones
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Programa Detalles --}}
    @can('programa_detalles.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-info-circle fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Detalles de Programas</h5>
                <a href="{{ route('programa_detalles.index') }}" class="btn btn-outline-warning btn-sm mt-3">
                    Gestionar detalles
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Novedades (tipos) --}}
    @can('novedades_tipos.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-exclamation-circle fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Tipos de Novedades</h5>
                <a href="{{ route('novedades.tipos.index') }}" class="btn btn-outline-danger btn-sm mt-3">
                    Gestionar tipos
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Permisos por Categorías --}}
    @can('permissions_categorias.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-layer-group fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Permisos por Categorías</h5>
                <a href="{{ route('permissions.categorias.index') }}" class="btn btn-outline-dark btn-sm mt-3">
                    Gestionar categorías
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Centros --}}
    @can('centros.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-school fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Centros Educativos</h5>
                <a href="{{ route('centros.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                    Ver centros educativos
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Usuarios --}}
    @can('users.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-users fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm mt-3">
                    Ver usuarios
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Roles --}}
    @can('roles.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-user-tag fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Roles</h5>
                <a href="{{ route('roles.index') }}" class="btn btn-outline-info btn-sm mt-3">
                    Ver roles
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Permisos --}}
    @can('permissions.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-key fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Permisos</h5>
                <a href="{{ route('permissions.index') }}" class="btn btn-outline-success btn-sm mt-3">
                    Ver permisos
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Configuración (SIN VALIDACIÓN DE PERMISOS) --}}
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-cogs fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Configuración</h5>
                <a href="#" class="btn btn-outline-warning btn-sm mt-3">
                    Ajustes
                </a>
            </div>
        </div>
    </div>

    {{-- Competencias --}}
    @can('competencias.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-trophy fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Competencias</h5>
                <a href="{{ route('competencias.index') }}" class="btn btn-outline-light btn-sm mt-3">
                    Ver competencias
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Historias de éxito --}}
    @can('historias_exito.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-book-open fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Historias de Éxito</h5>
                <a href="{{ route('historias_de_exito.index') }}" class="btn btn-outline-secondary btn-sm mt-3">
                    Ver historias de éxito
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Instructores --}}
    @can('instructores.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-chalkboard-teacher fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Instructores</h5>
                <a href="{{ route('instructores.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                    Ver instructores
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Niveles de formación --}}
    @can('niveles_formacion.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="bi bi-stack fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Niveles de Formación</h5>
                <a href="{{ route('niveles_formacion.index') }}" class="btn btn-outline-success btn-sm mt-3">
                    Ver niveles de formación
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Ofertas --}}
    @can('ofertas.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-graduation-cap fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Ofertas</h5>
                <a href="{{ route('ofertas.index') }}" class="btn btn-outline-info btn-sm mt-3">
                    Ver ofertas
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Programas --}}
    @can('programas.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-book fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Programas de formación</h5>
                <a href="{{ route('programas.index') }}" class="btn btn-outline-warning btn-sm mt-3">
                    Ver programas de formación
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Redes --}}
    @can('redes_conocimiento.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-network-wired fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Redes</h5>
                <a href="{{ route('redes_conocimiento.index') }}" class="btn btn-outline-light btn-sm mt-3">
                    Ver redes
                </a>
            </div>
        </div>
    </div>
    @endcan

    {{-- Carousel del Home --}}
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="bi bi-images fa-3x text-sena"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Carousel del Home</h5>
                <p class="text-muted small">Administra los slides del carousel institucional</p>
                <a href="{{ route('admin.home-carousel.index') }}" class="btn btn-sena btn-sm mt-3">
                    Gestionar carousel
                </a>
            </div>
        </div>
    </div>

</div>

</div>

@stop
