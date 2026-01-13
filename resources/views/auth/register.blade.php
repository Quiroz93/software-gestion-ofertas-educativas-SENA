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

        <!-- Acciones -->
        <div class="d-flex align-items-center justify-content-between mt-4">
            <a href="{{ route('login') }}" class="link-secondary text-decoration-none small">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>
            <button type="submit" class="btn btn-success">
                {{ __('Registrarse') }}
            </button>
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
