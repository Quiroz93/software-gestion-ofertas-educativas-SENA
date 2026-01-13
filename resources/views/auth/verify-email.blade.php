@extends('layouts.auth')

@section('title', __('Verificar Correo Electrónico'))

@section('content')
    <div class="mb-4 small text-secondary">
        {{ __('gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte? Si no recibiste el correo electrónico, ¡nosotros te enviaremos otro!') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 small text-success fw-bold">
            {{ __('Un nuevo enlace de verificación ha sido enviado a la dirección de correo electrónico que proporcionaste durante el registro.') }}
        </div>
    @endif

    <div class="mt-4 d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Reenviar correo de verificación') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">
                {{ __('Cerrar sesión') }}
            </button>
        </form>
    </div>
@endsection
