@extends('layouts.auth')

@section('title', __('Iniciar sesión'))

@section('content')
    <!-- Session Status -->
    @if ($status = session('status'))
        <div class="alert alert-success mb-3">{{ $status }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="bg-white border border-success rounded-3 p-4 shadow-sm">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Correo electrónico') }}</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Toggle Password -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="togglePassword">
            <label class="form-check-label" for="togglePassword">{{ __('Ver Contraseña') }}</label>
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">{{ __('Recordar usuario') }}</label>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-3">
            @if (Route::has('password.request'))
                <a class="link-secondary text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>
        <div class="row">
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-sm">
                {{ __('Iniciar sesión') }}
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
