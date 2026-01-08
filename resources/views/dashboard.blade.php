@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@endsection

@section('content')
<x-app-layout>

    {{-- Bootstrap (puedes cambiar a Vite si ya lo tienes compilado) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    @role('admin')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>

        <div class="alert alert-info alert-dismissible mb-3 py-2 px-3">
            <strong>
                {{ __('Bienvenido, :name', ['name' => auth()->user()->name]) }}
            </strong>
            <div class="small">
                {{ __('Acceso administrativo') }}
            </div>
        </div>

    </x-slot>
    @endrole


    <div class="container ">
        <div class="row ">
            @can('view_centros')
            <div class="col-md-4 mt-4">
                <div class=" text-center shadow-sm">

                    <div>
                        <i class="fas fa-building fa-4x mb-3"></i>
                    </div>
                    <h5 class=" mt-4">{{ __('Centros Educativos') }}</h5>
                    <div>


                        <div class="d-grid gap-2">
                            <a href="{{ route('centro.index') }}" class="btn btn-primary btn-sm" id="acciones">
                                {{ __('Gestionar') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endcan


            @can('usuarios.ver')
            <div class="col-md-4 mt-4">
                <div class=" text-center shadow-sm">
                    <div class="card-header">
                        <i class="fas fa-users fa-4x mb-3"></i>
                    </div>

                    <h5 class=" mt-4">{{ __('Usuarios') }}</h5>

                    <div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm" id="acciones">
                                {{ __('Ver usuarios') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            @endcan

            @role('admin')
            <div class="col-md-4 mt-4">
                <div class="text-center shadow-sm">

                    <div class="card-header">
                        <i class="fa-solid fa-wrench fa-4x mb-3"></i>
                    </div>

                    <h5 class="mt-4">{{ __('Configuración') }}</h5>

                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-warning btn-sm" id="acciones">
                            {{ __('Ajustes') }}
                        </a>
                    </div>
                </div>
            </div>
            @endrole
        </div>
        <div class="row">
            @can('view_roles')
            <div class="col-md-4 mt-4">
                <div class=" text-center shadow-sm">
                    <div class="card-header">
                        <i class="fa-solid fa-building-user fa-4x mb-3"></i>
                    </div>

                    <h5 class=" mt-4">{{ __('Roles') }}</h5>

                    <div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm" id="acciones">
                                {{ __('Roles') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            @endcan

            @can('view_permissions')
            <div class="col-md-4 mt-4">
                <div class=" text-center shadow-sm">
                    <div class="card-header">
                        <i class="fa-solid fa-check-to-slot fa-4x mb-3"></i>
                    </div>

                    <h5 class=" mt-4">{{ __('Permisos') }}</h5>

                    <div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-sm" id="acciones">
                                {{ __('Permisos') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            @endcan
        </div>
    </div>



    <div class="d-flex gap-2 flex-wrap mt-4">


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

        @can('view_roles')
        <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">Roles</a>
        @endcan

        @can('view_permissions')
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-primary">Permisos</a>
        @endcan

    </div>

    <style>
        #acciones {
            color: #fff;
            background-color: #007832;
            border-color: #007832;
        }

        .container {
            background-color: #fff;
        }
    </style>
</x-app-layout>
@endsection