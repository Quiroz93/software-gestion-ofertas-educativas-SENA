@extends('layouts.app')

@section('title', 'Panel de control')

@section('content_header') <h1 class="m-0">Panel de Administración</h1>
@stop

@section('content')

@can('dashboard.view')

<div class="alert alert-info alert-dismissible mb-3"> 
    <strong>
        {{ __('Bienvenido, :name', ['name' => auth()->user()->name]) }}
    </strong>
    <div class="small">
        {{ __('Acceso administrativo') }}
    </div>
</div>
@endcan

<div class="container-fluid">
    <div class="row">

    {{-- Centros --}}
    @can('centros.view')
    <div class="col-md-4 mt-4">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <i class="fas fa-school fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Centros Educativos</h5>
                <a href="{{ route('centros.index') }}" class="btn btn-primary btn-sm mt-3">
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
                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm mt-3">
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
                <a href="{{ route('roles.index') }}" class="btn btn-info btn-sm mt-3">
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
                <a href="{{ route('permissions.index') }}" class="btn btn-success btn-sm mt-3">
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
                <a href="#" class="btn btn-warning btn-sm mt-3">
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
                <a href="{{ route('competencias.index') }}" class="btn btn-dark btn-sm mt-3">
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
                <a href="{{ route('historias_de_exito.index') }}" class="btn btn-secondary btn-sm mt-3">
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
                <a href="{{ route('instructores.index') }}" class="btn btn-primary btn-sm mt-3">
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
                <i class="fa-solid fa-ranking-star fa-3x"></i>
            </div>
            <div class="card-body">
                <h5 class="card-title">Niveles de Formación</h5>
                <a href="{{ route('niveles_formacion.index') }}" class="btn btn-success btn-sm mt-3">
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
                <a href="{{ route('ofertas.index') }}" class="btn btn-info btn-sm mt-3">
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
                <a href="{{ route('programas.index') }}" class="btn btn-warning btn-sm mt-3">
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
                <a href="{{ route('redes_conocimiento.index') }}" class="btn btn-dark btn-sm mt-3">
                    Ver redes
                </a>
            </div>
        </div>
    </div>
    @endcan

</div>

</div>

@stop
