@extends('adminlte::page')

{{-- Título por defecto --}}
@section('title', 'SOES | Sistema de Ofertas Educativas')



{{-- Header común para todas las vistas --}}
@section('content_header')
    <div class="container-fluid">
        <h1 class="mb-1 font-weight-bold">
            @yield('page_title', 'Panel principal')
        </h1>
        <p class="text-muted mb-0">
            @yield('page_subtitle', 'Sistema de Gestión de Ofertas Educativas – SENA')
        </p>
    </div>
@stop

{{-- Contenido principal --}}
@section('content')
    <div class="container-fluid">
        @yield('content_body')
    </div>
@stop

{{-- Footer opcional --}}
@section('footer')
    <div class="text-center text-muted">
        <small>
            © {{ date('Y') }} SOES – Servicio Nacional de Aprendizaje (SENA)
        </small>
    </div>
@stop
{{-- Sección para incluir estilos adicionales --}}
