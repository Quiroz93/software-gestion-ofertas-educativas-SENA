<x-app-layout>

    {{-- Bootstrap (puedes cambiar a Vite si ya lo tienes compilado) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>

        {{-- Bienvenida --}}
        <div class="alert alert-info mb-4">
            <h4 class="alert-heading">
                {{ __('Bienvenido, :name', ['name' => auth()->user()->name]) }}
            </h4>
            <p>
                {{ __('Acceso administrativo') }}
            </p>
        </div>

        {{-- Métricas --}}
        <div class="row mb-4">

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Centros Educativos') }}</h5>
                        <p class="display-6"></p>
                        <a href="{{ route('centro.index') }}" class="btn btn-primary btn-sm">
                            {{ __('Gestionar') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Usuarios') }}</h5>
                        <p class="display-6"></p>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                            {{ __('Ver usuarios') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Configuración') }}</h5>
                        <p class="text-muted">{{ __('Sistema') }}</p>
                        <a href="#" class="btn btn-warning btn-sm">
                            {{ __('Ajustes') }}
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- Acciones rápidas --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ __('Acciones rápidas') }}</h5>

                <div class="d-flex gap-2 flex-wrap">

                    @can('crear centros')
                    <a href="{{ route('centro.index') }}" class="btn btn-success">
                        {{ __('Crear centro') }}
                    </a>
                    @endcan

                    @can('gestionar usuarios')
                    <a href="#" class="btn btn-outline-primary">
                        {{ __('Gestionar usuarios') }}
                    </a>
                    @endcan

                </div>
            </div>
        </div>

</x-app-layout>