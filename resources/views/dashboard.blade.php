<x-app-layout>

@extends('adminlte::page')
    {{-- Bootstrap (puedes cambiar a Vite si ya lo tienes compilado) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    @role('admin')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>

        <div class="alert alert-info mb-4">
            <h4 class="alert-heading">
                {{ __('Bienvenido, :name', ['name' => auth()->user()->name]) }}
            </h4>
            <p>{{ __('Acceso administrativo') }}</p>
        </div>
    </x-slot>
    @endrole


    <!-- Botones de acción -->

    

@can('view_roles')
<a href="{{ route('roles.index') }}" class="btn btn-primary mb-4 mt-3">Roles</a>
@endcan

@can('view_permissions')
<a href="{{ route('permissions.index') }}" class="btn btn-primary mb-4 mt-3">Permisos</a>
@endcan

    @can('view_centros')
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ __('Centros Educativos') }}</h5>

                <a href="{{ route('centro.index') }}" class="btn btn-primary btn-sm">
                    {{ __('Gestionar') }}
                </a>
            </div>
        </div>
    </div>
    @endcan


    @can('usuarios.ver')
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ __('Usuarios') }}</h5>

                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                    {{ __('Ver usuarios') }}
                </a>
            </div>
        </div>
    </div>
    @endcan

    @role('admin')
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ __('Configuración') }}</h5>

                <a href="#" class="btn btn-warning btn-sm">
                    {{ __('Ajustes') }}
                </a>
            </div>
        </div>
    </div>
    @endrole

    <div class="d-flex gap-2 flex-wrap">

        @can('create_centros')
        <a href="{{ route('centro.create') }}" class="btn btn-success">
            {{ __('Crear centro') }}
        </a>
        @endcan

        @can('manage_users')
        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
            {{ __('Gestionar usuarios') }}
        </a>
        @endcan

    </div>
</x-app-layout>