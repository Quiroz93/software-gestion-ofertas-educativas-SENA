@extends('layouts.app')

@section('title', 'Panel de control')

@section('content_header')
    <h1 class="m-0">Panel de Administración</h1>
@stop

@section('content')

@can('access_admin_panel')
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
                    <a href="{{ route('centro.index') }}" class="btn btn-primary btn-sm mt-3">
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

        {{-- Configuración --}}
        
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
        

    </div>
</div>

@stop
