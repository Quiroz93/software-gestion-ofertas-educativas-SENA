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

                    <!-- Editor de TEXTO -->
                    <div id="textEditor" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Contenido</label>
                            <textarea class="form-control" id="cc-value" rows="4"></textarea>
                        </div>
                    </div>

                    <!-- Editor de MULTIMEDIA -->
                    <div id="mediaEditor" style="display: none;">
                        
                        <!-- Preview del archivo actual -->
                        <div class="mb-3">
                            <label class="form-label">Archivo actual:</label>
                            <div id="currentMediaPreview" class="border p-3 text-center bg-light" style="min-height: 150px;">
                                <p class="text-muted mb-0">No hay archivo asignado</p>
                            </div>
                        </div>

                        <!-- Tabs: Archivos existentes o Subir nuevo -->
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="existing-tab" data-toggle="tab" href="#existingFiles" role="tab">
                                    <i class="bi bi-images"></i> Archivos existentes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="upload-tab" data-toggle="tab" href="#uploadNew" role="tab">
                                    <i class="bi bi-cloud-upload"></i> Subir nuevo
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            
                            <!-- TAB 1: Archivos existentes -->
                            <div class="tab-pane fade show active" id="existingFiles" role="tabpanel">
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="fileSearchInput" 
                                           placeholder="🔍 Buscar archivo...">
                                </div>
                                <div id="filesGrid" class="row g-2" style="max-height: 300px; overflow-y: auto;">
                                    <div class="col-12 text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Cargando...</span>
                                        </div>
                                        <p class="text-muted mt-2 mb-0">Cargando archivos...</p>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: Subir nuevo archivo -->
                            <div class="tab-pane fade" id="uploadNew" role="tabpanel">
                                <div class="mb-3">
                                    <label class="form-label">Seleccionar archivo:</label>
                                    <input type="file" class="form-control" id="mediaFileInput" 
                                           accept="image/*,video/*">
                                </div>

                                <!-- Drag & Drop Zone -->
                                <div id="dropZone" class="border border-dashed rounded p-5 text-center bg-light" 
                                     style="cursor: pointer; transition: all 0.3s;">
                                    <i class="bi bi-cloud-upload" style="font-size: 3rem; color: #6c757d;"></i>
                                    <p class="mt-3 mb-0 text-muted">
                                        <strong>Arrastra un archivo aquí</strong><br>
                                        o haz clic para seleccionar
                                    </p>
                                    <small class="text-muted">Máx. 50MB - JPG, PNG, GIF, WebP, MP4, WebM</small>
                                </div>

                                <!-- Progress Bar -->
                                <div id="uploadProgress" class="mt-3" style="display: none;">
                                    <label class="form-label small">Subiendo archivo...</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                             role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>

                                <!-- Preview del archivo nuevo -->
                                <div id="newMediaPreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Vista previa:</label>
                                    <div class="border p-3 text-center bg-white">
                                        <!-- Preview se carga aquí dinámicamente -->
                                    </div>
                                </div>
                            </div>

                        </div>
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
        let selectedFile = null; // Archivo seleccionado para guardar

        // 1️⃣ Click sobre elemento editable
        $('.editable').on('click', function () {
            currentEditable = this;

            $('#cc-model').val(this.dataset.model);
            $('#cc-model-id').val(this.dataset.modelId);
            $('#cc-key').val(this.dataset.key);
            $('#cc-type').val(this.dataset.type);

            const dataType = this.dataset.type || 'text';

            // Detectar tipo de contenido y mostrar editor correspondiente
            if (dataType === 'image' || dataType === 'video') {
                showMediaEditor(dataType);
            } else {
                showTextEditor();
            }

            $modal.modal('show');
        });

        // 📝 Mostrar editor de TEXTO
        function showTextEditor() {
            $('#textEditor').show();
            $('#mediaEditor').hide();
            $('#editContentModalLabel').text('Editar contenido de texto');
            
            // Cargar valor actual
            $value.val(currentEditable.innerText.trim());
        }

        // 🖼️ Mostrar editor de MULTIMEDIA
        function showMediaEditor(type) {
            $('#textEditor').hide();
            $('#mediaEditor').show();
            $('#editContentModalLabel').text(type === 'image' ? 'Editar imagen' : 'Editar video');
            
            selectedFile = null; // Reset archivo seleccionado

            // Mostrar archivo actual si existe
            const currentSrc = currentEditable.src || currentEditable.getAttribute('data-src');
            if (currentSrc) {
                if (type === 'video') {
                    // Preview mejorado para videos
                    $('#currentMediaPreview').html(`
                        <video controls 
                               style="width: 100%; max-height: 200px; background: #000;">
                            <source src="${currentSrc}" type="video/mp4">
                            Tu navegador no soporta el elemento video.
                        </video>
                    `);
                } else {
                    // Preview para imágenes
                    $('#currentMediaPreview').html(`
                        <img src="${currentSrc}" 
                             alt="Imagen actual"
                             class="img-fluid" 
                             style="max-height: 150px; max-width: 100%;">
                    `);
                }
            } else {
                $('#currentMediaPreview').html('<p class="text-muted mb-0">No hay archivo asignado</p>');
            }

            // Resetear tabs y mostrar "Archivos existentes"
            $('#existing-tab').tab('show');

            // Cargar archivos del sistema
            loadExistingFiles(type);
        }

        // 📂 Cargar archivos existentes del servidor
        function loadExistingFiles(type) {
            const model = $('#cc-model').val();
            
            // Mostrar loading
            $('#filesGrid').html(`
                <div class="col-12 text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                    <p class="text-muted mt-2 mb-0">Cargando archivos...</p>
                </div>
            `);

            const url = `/public/media/list?type=${type}&category=${model}`;

            fetch(url, {
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Error al cargar archivos');
                return res.json();
            })
            .then(data => {
                if (data.files && data.files.length > 0) {
                    renderFilesGrid(data.files, type);
                } else {
                    $('#filesGrid').html(`
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder2-open" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-3 mb-0">No hay archivos disponibles en esta categoría</p>
                            <small class="text-muted">Usa la pestaña "Subir nuevo" para agregar archivos</small>
                        </div>
                    `);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                $('#filesGrid').html(`
                    <div class="col-12 text-center py-4">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                        <p class="text-danger mt-2 mb-0">Error al cargar archivos</p>
                        <small class="text-muted">${error.message}</small>
                    </div>
                `);
            });
        }

        // 🖼️ Renderizar grid de archivos con selección y lazy loading
        function renderFilesGrid(files, type) {
            let html = '';

            files.forEach(file => {
                const isVideo = type === 'video';
                
                // Para videos, usar poster si está disponible
                // Para imágenes, usar thumbnail
                let displayUrl = file.url; // Fallback
                
                if (isVideo) {
                    displayUrl = file.poster_url || file.url;
                } else {
                    displayUrl = file.thumbnail_url || file.url;
                }
                
                // Tag multimedia
                let mediaTag = '';
                if (isVideo) {
                    // Mostrar poster con ícono de play
                    mediaTag = `
                        <div style="position: relative; width: 100%; height: 120px; overflow: hidden;">
                            <img src="${displayUrl}" alt="${file.name}" 
                                 class="img-fluid lazy-load" 
                                 data-src="${displayUrl}"
                                 style="width: 100%; height: 120px; object-fit: cover; background: #222;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                <i class="bi bi-play-circle" style="font-size: 2.5rem; color: rgba(255,255,255,0.8);"></i>
                            </div>
                        </div>
                    `;
                } else {
                    // Imagen simple con lazy loading
                    mediaTag = `
                        <img src="${displayUrl}" alt="${file.name}" 
                             class="img-fluid lazy-load" 
                             data-src="${displayUrl}"
                             style="width: 100%; height: 120px; object-fit: cover; background: #f0f0f0;">
                    `;
                }

                html += `
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="card file-card h-100" 
                             style="cursor: pointer; transition: all 0.2s;"
                             data-file='${JSON.stringify(file)}'>
                            <div class="card-body p-2">
                                ${mediaTag}
                                <small class="d-block mt-2 text-truncate" title="${file.name}">
                                    ${file.name}
                                </small>
                                <small class="d-block text-muted">(${formatFileSize(file.size)})</small>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#filesGrid').html(html);

            // Lazy loading de imágenes y posters
            if ('IntersectionObserver' in window) {
                initLazyLoading();
            }

            // Click para seleccionar archivo
            $('.file-card').on('click', function() {
                // Remover selección previa
                $('.file-card').removeClass('border-primary').css('border-width', '1px');
                
                // Marcar como seleccionado
                $(this).addClass('border-primary').css('border-width', '3px');
                
                // Guardar archivo seleccionado
                selectedFile = JSON.parse($(this).attr('data-file'));
                
                console.log('Archivo seleccionado:', selectedFile);
            });
        }

        // � Implementar búsqueda de archivos
        $('#fileSearchInput').on('keyup', function() {
            const query = $(this).val().toLowerCase();
            const cards = $('.file-card');

            cards.each(function() {
                const fileName = $(this).find('small').first().text().toLowerCase();
                const shouldShow = fileName.includes(query);
                
                $(this).closest('.col-md-3, .col-sm-4, .col-6')
                    .toggle(shouldShow);
            });

            // Mostrar mensaje si no hay resultados
            const visibleCards = cards.filter(function() {
                return $(this).closest('.col-md-3, .col-sm-4, .col-6').is(':visible');
            });

            if (visibleCards.length === 0) {
                if (!$('#noResultsMessage').length) {
                    $('#filesGrid').append(`
                        <div class="col-12 text-center py-4" id="noResultsMessage">
                            <i class="bi bi-search text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">No se encontraron archivos</p>
                        </div>
                    `);
                }
            } else {
                $('#noResultsMessage').remove();
            }
        });

        // �🚀 Inicializar lazy loading con Intersection Observer
        function initLazyLoading() {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const src = img.getAttribute('data-src');
                        
                        if (src) {
                            img.src = src;
                            img.removeAttribute('data-src');
                            img.classList.remove('lazy-load');
                            observer.unobserve(img);
                        }
                    }
                });
            });

            // Observar todas las imágenes con clase lazy-load
            document.querySelectorAll('img.lazy-load').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // 📦 Formatea tamaño de archivo a formato legible
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // 📤 File input y preview de archivo nuevo
        $('#mediaFileInput').on('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            showNewFilePreview(file);
        });

        // Drag & Drop Zone
        $('#dropZone').on('click', function() {
            $('#mediaFileInput').click();
        });

        $('#dropZone').on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('border-primary bg-white');
        });

        $('#dropZone').on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-primary bg-white');
        });

        $('#dropZone').on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('border-primary bg-white');

            const files = e.originalEvent.dataTransfer.files;
            if (files.length > 0) {
                $('#mediaFileInput')[0].files = files;
                showNewFilePreview(files[0]);
            }
        });

        function showNewFilePreview(file) {
            const reader = new FileReader();
            const isVideo = file.type.startsWith('video/');

            reader.onload = function(e) {
                const mediaTag = isVideo
                    ? `<video src="${e.target.result}" controls class="img-fluid" style="max-height: 250px;"></video>`
                    : `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 250px;">`;

                $('#newMediaPreview').show().find('> div').html(`
                    ${mediaTag}
                    <small class="d-block mt-2 text-muted">
                        <strong>${file.name}</strong> (${(file.size / 1024 / 1024).toFixed(2)} MB)
                    </small>
                `);

                // Auto-subir archivo
                uploadFile(file);
            };

            reader.readAsDataURL(file);
        }

        // 📤 Upload file al servidor
        function uploadFile(file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', $('#cc-type').val());
            formData.append('category', $('#cc-model').val());

            // Mostrar barra de progreso
            $('#uploadProgress').show();
            const $progressBar = $('#uploadProgress .progress-bar');

            fetch('/public/media/upload', {
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(res => {
                if (!res.ok) throw new Error('Error al subir archivo');
                return res.json();
            })
            .then(data => {
                // Simular progreso completo
                $progressBar.css('width', '100%');

                setTimeout(() => {
                    $('#uploadProgress').hide();
                    $progressBar.css('width', '0%');
                }, 500);

                // Guardar archivo subido como seleccionado
                selectedFile = {
                    path: data.path,
                    url: data.url,
                    name: file.name,
                    size: file.size,
                    type: file.type
                };

                console.log('Archivo subido correctamente:', selectedFile);
                alert('✅ Archivo subido correctamente. Ahora haz clic en "Guardar cambios".');
            })
            .catch(error => {
                console.error('Error:', error);
                $('#uploadProgress').hide();
                $progressBar.css('width', '0%');
                alert('❌ Error al subir archivo: ' + error.message);
            });
        }

        // 2️⃣ Guardar contenido
        $('#saveContentBtn').on('click', () => {
            const contentType = $('#cc-type').val();

            // Detectar si es multimedia o texto
            if (contentType === 'image' || contentType === 'video') {
                saveMediaContent();
            } else {
                saveTextContent();
            }
        });

        // Guardar contenido de TEXTO
        function saveTextContent() {
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
        }

        // Guardar contenido MULTIMEDIA
        function saveMediaContent() {
            if (!selectedFile) {
                alert('⚠️ Debes seleccionar un archivo primero');
                return;
            }

            const payload = {
                model: $('#cc-model').val(),
                model_id: $('#cc-model-id').val(),
                key: $('#cc-key').val(),
                type: $('#cc-type').val(),
                file_path: selectedFile.path,
                metadata: {
                    url: selectedFile.url,
                    name: selectedFile.name,
                    size: selectedFile.size,
                    mime_type: selectedFile.type
                }
            };

            fetch('/public/media/store', {
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
                    if (!res.ok) {
                        const err = await res.json();
                        throw new Error(err.message || 'Error al guardar multimedia');
                    }
                    return res.json();
                })
                .then((data) => {
                    console.log('Multimedia guardada:', data);

                    // Actualizar elemento en vista
                    if (currentEditable) {
                        const mediaType = $('#cc-type').val();
                        
                        if (mediaType === 'image' || currentEditable.tagName === 'IMG') {
                            // Actualizar imagen
                            currentEditable.src = selectedFile.url;
                        } else if (mediaType === 'video' || currentEditable.tagName === 'VIDEO') {
                            // Actualizar video con source element
                            const sourceElement = currentEditable.querySelector('source');
                            
                            if (sourceElement) {
                                // Si existe <source>, actualizar su src
                                sourceElement.src = selectedFile.url;
                            } else {
                                // Si no existe <source>, crear uno
                                const source = document.createElement('source');
                                source.src = selectedFile.url;
                                source.type = selectedFile.type || 'video/mp4';
                                currentEditable.appendChild(source);
                            }
                            
                            // Recargar el video
                            currentEditable.load();
                        }
                    }

                    $modal.modal('hide');
                    alert('✅ Multimedia actualizada correctamente');
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('❌ Error al guardar multimedia: ' + error.message);
                });
        }
    });
</script>
@endcan
@stack('scripts')
@endsection