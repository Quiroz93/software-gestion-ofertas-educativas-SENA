@extends('adminlte::page')

@section('title', config('app.name', 'SENA'))
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">


{{-- SEO básico --}}
<meta name="description" content="@yield('meta_description', 'Plataforma educativa SOESoftware')">

{{-- Favicon --}}
<link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

{{-- Bootstrap 5 --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


{{-- CSS público --}}
{{-- <link href="{{ asset('css/public.css') }}" rel="stylesheet"> --}}

@stack('styles')

@endsection

@section('content')
{{-- Navbar pública --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('public.home') }}">
            SOESoftware
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarPublic" aria-controls="navbarPublic"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPublic">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.programas.index') }}">Programas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.ofertas.index') }}">Ofertas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.instructores.index') }}">Instructores</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('public.noticias.index') }}">Noticias</a>
                </li>

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

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

@can('public_content.edit')
<div class="modal fade" id="editContentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editar contenido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                    data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="saveContentBtn">
                    Guardar cambios
                </button>
            </div>

        </div>
    </div>
</div>
@endcan

@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('js')

@can('edit public content')
@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const modalEl = document.getElementById('editContentModal');
        const modal = new bootstrap.Modal(modalEl);

        let currentEditable = null;

        // 1️⃣ Click sobre elemento editable
        document.querySelectorAll('.editable').forEach(el => {
            el.addEventListener('click', () => {

                currentEditable = el;

                document.getElementById('cc-model').value = el.dataset.model;
                document.getElementById('cc-model-id').value = el.dataset.modelId;
                document.getElementById('cc-key').value = el.dataset.key;
                document.getElementById('cc-type').value = el.dataset.type;

                document.getElementById('cc-value').value =
                    el.innerText.trim();

                modal.show();
            });
        });

        // 2️⃣ Guardar contenido
        document.getElementById('saveContentBtn')
            .addEventListener('click', () => {

                const payload = {
                    model: document.getElementById('cc-model').value,
                    model_id: document.getElementById('cc-model-id').value,
                    key: document.getElementById('cc-key').value,
                    value: document.getElementById('cc-value').value,
                    type: document.getElementById('cc-type').value,
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
                    .then(res => res.json())
                    .then(data => {

                        // Actualiza el contenido en la vista
                        currentEditable.innerText = payload.value;

                        modal.hide();
                    })
                    .catch(() => {
                        alert('Error al guardar el contenido');
                    });
            });

    });
</script>
@endpush
@endcan
@endsection