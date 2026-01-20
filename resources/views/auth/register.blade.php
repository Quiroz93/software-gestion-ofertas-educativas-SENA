@extends('layouts.auth')

@section('title', __('Registro de Usuario'))

@section('content')
<form method="POST" action="{{ route('register') }}" class="bg-white border border-success rounded-3 p-4 shadow-sm">
    @csrf

    <!-- Título -->
    <h2 class="h4 text-center text-success mb-4">
        {{ __('Registro de Usuario') }}
    </h2>

    <!-- Nombre -->
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Nombre') }}</label>
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
            name="name" value="{{ old('name') }}" required autofocus />
        @error('name')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
            name="email" value="{{ old('email') }}" required />
        @error('email')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Contraseña') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required />
        @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Toggle Password -->
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="togglePassword">
        <label class="form-check-label" for="togglePassword">{{ __('Ver Contraseña') }}</label>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            name="password_confirmation" required />
        @error('password_confirmation')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <!-- Owner Key -->
    <!-- Si el sistema no está inicializado, se solicita la owner_key -->
    @if (!config('System.initialized'))

    <p class="text-danger small">
        {{ __('* Bienvenido: Esta clave es necesaria para inicializar el sistema. Solo se necesitará una vez. Si no se proporciona, El sistema asignara un usuariio por defecto y seguira esperando la inicialización.') }}
    </p>
    <div class="mb-3">
        <label for="owner_key" class="form-label">
            Clave de inicialización del sistema
        </label>

        <input
            type="password"
            name="owner_key"
            id="owner_key"
            class="form-control @error('owner_key') is-invalid @enderror"
            required>
        @error('owner_key')
        <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

    </div>
    @endif


    <!-- Acciones -->
    <div class="d-flex align-items-center justify-content-between mt-4">
        <a href="{{ route('login') }}" class="link-secondary text-decoration-none small">
            {{ __('¿Ya tienes una cuenta?') }}
        </a>
    </div>
    <div class="row mt-4">
        <div class="col-6">
            <button type="submit" class="btn btn-success btn-sm">
                {{ __('Registrarse') }}
            </button>
        </div>
        <div class="col-6">
            <a href="" class="btn btn-secondary float-end btn-sm">Cancelar</a>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleCheckbox = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toggleCheckbox && passwordInput) {
            toggleCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    passwordInput.type = 'text';
                } else {
                    passwordInput.type = 'password';
                }
            });
        }
    });
</script>
@endsection
