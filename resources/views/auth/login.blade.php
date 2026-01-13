@extends('layouts.auth')

@section('title', __('Iniciar sesión'))

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="invalid-feedback d-block" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="form-control"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="invalid-feedback d-block" />
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="togglePassword" onclick="myFunction()">
            <label class="form-check-label" for="togglePassword">Ver Contraseña</label>
            <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";        
              } else {
                x.type = "password";
              }
            }   
            </script>
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label class="form-check-label" for="remember_me">
                {{ __('Recordar usuario') }}
            </label>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-3">
            @if (Route::has('password.request'))
                <a class="link-secondary text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
    </form>
@endsection
