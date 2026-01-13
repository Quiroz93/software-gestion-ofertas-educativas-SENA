@extends('layouts.auth')

@section('title', __('Recuperar Contraseña'))

@section('content')
    <div class="mb-4 small text-secondary">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo haznos saber tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
    </div>

    @if ($status = session('status'))
        <div class="alert alert-success mb-4">{{ $status }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Enviar enlace de restablecimiento') }}
            </button>
        </div>
    </form>
@endsection
