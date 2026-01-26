@extends('adminlte::page')

@section('title', config('app.name', 'SENA'))

@section('adminlte_css_pre')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SEO básico --}}
<meta name="description" content="@yield('meta_description', 'Plataforma educativa SOESoftware')">

{{-- Favicon --}}
<link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

{{-- Bootstrap Icons (AdminLTE usa Bootstrap 4) --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endsection

@section('css')
@can('public_content.edit')
<style>
    .editable {
        position: relative;
        cursor: pointer;
    }

    .editable:hover {
        outline: 2px dashed #ffc107;
        background-color: rgba(255, 193, 7, 0.1);
        transition: all 0.2s ease;
    }

    .editable:hover::after {
        content: '\f4cb'; /* Bootstrap Icon pencil-square */
        font-family: 'bootstrap-icons';
        position: absolute;
        top: 5px;
        right: 5px;
        background: #ffc107;
        color: #000;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
@endcan
@stack('styles')
@endsection

@section('content')
{{-- Navbar pública --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('public.home') }}">
            SOESoftware
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarPublic" aria-controls="navbarPublic"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPublic">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.programasDeFormacion.index') }}">Programas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.ofertasEducativas.index') }}">Ofertas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.instructoresDeFormacion.index') }}">Instructores</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.ultimaNoticias.index') }}">Noticias</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-muted">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </span>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- Contenido principal --}}
<main class="py-4">
    <div class="container">
        @yield('content')
    </div>
</main>

{{-- Footer --}}
<footer class="bg-dark text-light py-4 mt-auto">
    <div class="container text-center">
        <small>
            © {{ date('Y') }} SOESoftware · Todos los derechos reservados
        </small>
    </div>
</footer>

@endsection

@section('js')
@can('public_content.edit')
<!-- Modal para editar contenido -->
<div class="modal fade" id="editContentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editar contenido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="editContentForm">
                    @csrf

                    <input type="hidden" id="cc-model">
                    <input type="hidden" id="cc-model-id">
                    <input type="hidden" id="cc-key">
                    <input type="hidden" id="cc-type">

                    <div class="mb-3">
                        <label class="form-label">Contenido</label>
                        <textarea class="form-control" id="cc-value" rows="4"></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveContentBtn">
                    Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    $(function () {
        const $modal = $('#editContentModal');
        const $value = $('#cc-value');
        let currentEditable = null;

        // 1️⃣ Click sobre elemento editable
        $('.editable').on('click', function () {
            currentEditable = this;

            $('#cc-model').val(this.dataset.model);
            $('#cc-model-id').val(this.dataset.modelId);
            $('#cc-key').val(this.dataset.key);
            $('#cc-type').val(this.dataset.type);

            $value.val(this.innerText.trim());

            $modal.modal('show');
        });

        // 2️⃣ Guardar contenido
        $('#saveContentBtn').on('click', () => {
            const payload = {
                model: $('#cc-model').val(),
                model_id: $('#cc-model-id').val(),
                key: $('#cc-key').val(),
                value: $value.val(),
                type: $('#cc-type').val(),
            };

            fetch("{{ route('public.content.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(async res => {
                    const contentType = res.headers.get('content-type');
                    if (contentType && contentType.includes('text/html')) {
                        throw new Error('Error del servidor. Por favor, verifica tus permisos o contacta al administrador.');
                    }

                    if (!res.ok) {
                        const err = await res.json();

                        if (err.errors) {
                            const errorMessages = Object.values(err.errors).flat().join('\n');
                            throw new Error('Errores de validación:\n' + errorMessages);
                        }

                        throw new Error(err.message || 'Error al guardar');
                    }
                    return res.json();
                })
                .then(() => {
                    if (currentEditable) {
                        currentEditable.innerText = payload.value;
                    }

                    $modal.modal('hide');
                    alert('Contenido actualizado correctamente');
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Error al guardar el contenido: ' + error.message);
                });
        });
    });
</script>
@endcan
@stack('scripts')
@endsection