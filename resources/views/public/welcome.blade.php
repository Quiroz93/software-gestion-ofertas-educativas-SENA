<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Ofertas Educativas | SENA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicons/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
            content: '\f4cb';
            /* Bootstrap Icon pencil-square */
            font-family: 'bootstrap-icons';
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ffc107;
            color: #000;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
    @endcan
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center me-2">
                <span class="brand-image">
                    {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
                </span>
            </a>

            <style>
                .brand-image svg {
                    width: 40px;
                    height: 40px;
                    color: #39A900;
                    margin-right: 1rem;
                }
            </style>

            <a class="navbar-brand text-white editable" href="#" style="font-size:1rem;" data-model="home" data-model-id="0" data-key="navbar_brand" data-type="text">
                {{ getCustomContent('home', 'navbar_brand', 'SOE | SENA') }}
            </a>

            <!-- Responsive -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAuth">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAuth">
                <div class="ms-auto d-flex flex-wrap gap-3 align-items-center">

                    <ul class="navbar-nav flex-row gap-3 small">
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena editable" href="#" data-model="home" data-model-id="0" data-key="nav_link_1" data-type="text">{{ getCustomContent('home', 'nav_link_1', 'Inicio') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena editable" href="#" data-model="home" data-model-id="0" data-key="nav_link_2" data-type="text">{{ getCustomContent('home', 'nav_link_2', 'Servicios') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white text-decoration-underline hover-sena editable" href="#" data-model="home" data-model-id="0" data-key="nav_link_3" data-type="text">{{ getCustomContent('home', 'nav_link_3', 'Contacto') }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="hero-card text-center">

                        <h1 class="fw-bold mb-3 mt-5 editable" data-model="home" data-model-id="0" data-key="hero_title" data-type="text">
                            {{ getCustomContent('home', 'hero_title', 'Sistema de Ofertas Educativas SENA - CATA') }}
                        </h1>

                        <p class="text-muted fs-5 mb-4 editable" data-model="home" data-model-id="0" data-key="hero_subtitle" data-type="text">
                            {{ getCustomContent('home', 'hero_subtitle', 'Plataforma institucional para la administración, control y publicación de ofertas educativas del SENA - Santander.') }}
                        </p>

                        {{-- Carousel --}}
                        <div id="carouselExampleIndicators" class="carousel slide mb-5">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                            </div>

                            <div class="carousel-inner rounded">
                                <div class="carousel-item active">
                                    <img src="{{ getCustomContent('home', 'carousel_image_1', asset('images/oferta1.jpeg')) }}" class="d-block w-100 editable" alt="Imagen 1" data-model="home" data-model-id="0" data-key="carousel_image_1" data-type="image">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ getCustomContent('home', 'carousel_image_2', asset('images/oferta2.jpeg')) }}" class="d-block w-100 editable" alt="Imagen 2" data-model="home" data-model-id="0" data-key="carousel_image_2" data-type="image">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ getCustomContent('home', 'carousel_image_3', asset('images/oferta3.jpeg')) }}" class="d-block w-100 editable" alt="Imagen 3" data-model="home" data-model-id="0" data-key="carousel_image_3" data-type="image">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        {{-- Noticias --}}
                        <section class="py-5">
                            <div class="container">
                                <h2 class="text-center fw-bold mb-4 editable" data-model="home" data-model-id="0" data-key="news_title" data-type="text">{{ getCustomContent('home', 'news_title', 'Últimas Noticias') }}</h2>
                                <div class="row">
                                    @if(isset($noticias) && $noticias->count() > 0)
                                    @foreach($noticias as $noticia)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100">
                                            @if($noticia->imagen)
                                            <img src="{{ asset('storage/' . $noticia->imagen) }}" class="card-img-top" alt="{{ $noticia->titulo }}">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $noticia->titulo }}</h5>
                                                <p class="card-text">{{ Str::limit($noticia->contenido, 100) }}</p>
                                            </div>
                                            <div class="card-footer">
                                                <a href="#" class="btn btn-primary btn-sm">Leer más</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col">
                                        <p class="text-center text-muted editable" data-model="home" data-model-id="0" data-key="no_news_message" data-type="text">{{ getCustomContent('home', 'no_news_message', 'No hay noticias disponibles en este momento.') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- Ofertas --}}
                        <section class="py-5 bg-light">
                            <div class="container">
                                <h2 class="text-center fw-bold mb-4 editable" data-model="home" data-model-id="0" data-key="offers_title" data-type="text">{{ getCustomContent('home', 'offers_title', 'Ofertas Educativas Recientes') }}</h2>
                                <div class="row">
                                    @if(isset($ofertas) && $ofertas->count() > 0)
                                    @foreach($ofertas as $oferta)
                                    <div class="col-md-3 mb-4">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $oferta->nombre }}</h5>
                                                <p class="card-text">{{ Str::limit($oferta->descripcion, 100) }}</p>
                                            </div>
                                            <div class="card-footer">
                                                <a href="#" class="btn btn-success btn-sm">Ver oferta</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col">
                                        <p class="text-center text-muted editable" data-model="home" data-model-id="0" data-key="no_offers_message" data-type="text">{{ getCustomContent('home', 'no_offers_message', 'No hay ofertas disponibles en este momento.') }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </section>

                        {{-- Características --}}
                        <div class="row g-4">

                            <div class="col-md-3">
                                <i class="bi bi-building feature-icon"></i>
                                <h6 class="fw-bold editable" data-model="home" data-model-id="0" data-key="feature_1_title" data-type="text">{{ getCustomContent('home', 'feature_1_title', 'Centros') }}</h6>
                                <p class="text-muted small editable" data-model="home" data-model-id="0" data-key="feature_1_text" data-type="text">{{ getCustomContent('home', 'feature_1_text', 'Gestión de centros de formación.') }}</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-journal-bookmark feature-icon"></i>
                                <h6 class="fw-bold editable" data-model="home" data-model-id="0" data-key="feature_2_title" data-type="text">{{ getCustomContent('home', 'feature_2_title', 'Programas') }}</h6>
                                <p class="text-muted small editable" data-model="home" data-model-id="0" data-key="feature_2_text" data-type="text">{{ getCustomContent('home', 'feature_2_text', 'Administración de programas educativos.') }}</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-mortarboard feature-icon"></i>
                                <h6 class="fw-bold editable" data-model="home" data-model-id="0" data-key="feature_3_title" data-type="text">{{ getCustomContent('home', 'feature_3_title', 'Ofertas') }}</h6>
                                <p class="text-muted small editable" data-model="home" data-model-id="0" data-key="feature_3_text" data-type="text">{{ getCustomContent('home', 'feature_3_text', 'Control de ofertas educativas vigentes.') }}</p>
                            </div>

                            <div class="col-md-3">
                                <i class="bi bi-newspaper feature-icon"></i>
                                <h6 class="fw-bold editable" data-model="home" data-model-id="0" data-key="feature_4_title" data-type="text">{{ getCustomContent('home', 'feature_4_title', 'Noticias') }}</h6>
                                <p class="text-muted small editable" data-model="home" data-model-id="0" data-key="feature_4_text" data-type="text">{{ getCustomContent('home', 'feature_4_text', 'Últimas noticias y novedades.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- FOOTER --}}
    <footer class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_col_1_title" data-type="text">{{ getCustomContent('home', 'footer_col_1_title', 'Centro') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_1_link_1" data-type="text">{{ getCustomContent('home', 'footer_col_1_link_1', 'Sobre nosotros') }}</a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_1_link_2" data-type="text">{{ getCustomContent('home', 'footer_col_1_link_2', 'Programas') }}</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_col_2_title" data-type="text">{{ getCustomContent('home', 'footer_col_2_title', 'Servicios') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_2_link_1" data-type="text">{{ getCustomContent('home', 'footer_col_2_link_1', 'Características') }}</a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_2_link_2" data-type="text">{{ getCustomContent('home', 'footer_col_2_link_2', 'información') }}</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_col_3_title" data-type="text">{{ getCustomContent('home', 'footer_col_3_title', 'Recursos') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_3_link_1" data-type="text">{{ getCustomContent('home', 'footer_col_3_link_1', 'Blog') }}</a></li>
                        <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_3_link_2" data-type="text">{{ getCustomContent('home', 'footer_col_3_link_2', 'Centro de ayuda') }}</a></li>
                        <!-- more links -->
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_col_4_title" data-type="text">{{ getCustomContent('home', 'footer_col_4_title', 'Contactanos') }}</h5>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_4_line_1" data-type="text">{{ getCustomContent('home', 'footer_col_4_line_1', 'Cra. 11 No. 13-13') }}</p>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_4_line_2" data-type="text">{{ getCustomContent('home', 'footer_col_4_line_2', 'Linea de atención: 018000 910270') }}</p>
                    <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_col_4_line_3" data-type="text">{{ getCustomContent('home', 'footer_col_4_line_3', 'Email: servicioalciudadano@sena.udu.co') }}</p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <p class="text-center text-muted border-top pt-3 editable" data-model="home" data-model-id="0" data-key="footer_copyright" data-type="text">{{ getCustomContent('home', 'footer_copyright', '© 2026 SENA, Centro Agroempresarial y Turístico de los Andes.') }}</p>
                </div>
            </div>
        </div>
    </footer>

    @can('public_content.edit')
    <!-- Modal para editar contenido -->
    <div class="modal fade" id="editContentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Editar contenido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="existing-tab" data-bs-toggle="tab" data-bs-target="#existingFiles" type="button" role="tab">
                                        <i class="bi bi-images"></i> Archivos existentes
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#uploadNew" type="button" role="tab">
                                        <i class="bi bi-cloud-upload"></i> Subir nuevo
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <!-- TAB 1: Archivos existentes -->
                                <div class="tab-pane fade show active" id="existingFiles" role="tabpanel">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="fileSearchInput" placeholder="🔍 Buscar archivo...">
                                    </div>
                                    <div id="filesGrid" class="row g-2" style="max-height: 300px; overflow-y: auto;">
                                        <div class="col-12 text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Cargando...</span>
                                            </div>
                                            <p class="text-muted mt-2 mb-0">Cargando archivos...</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 2: Subir nuevo archivo -->
                                <div class="tab-pane fade" id="uploadNew" role="tabpanel">
                                    <div class="mb-3">
                                        <label class="form-label">Seleccionar archivo:</label>
                                        <input type="file" class="form-control" id="mediaFileInput" accept="image/*,video/*">
                                    </div>

                                    <!-- Drag & Drop Zone -->
                                    <div id="dropZone" class="border border-dashed rounded p-5 text-center bg-light" style="cursor: pointer; transition: all 0.3s;">
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
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
        const $modal = new bootstrap.Modal(document.getElementById('editContentModal'));
        const $value = $('#cc-value');
        let currentEditable = null;
        let selectedFile = null;

        $('.editable').on('click', function () {
            currentEditable = this;

            $('#cc-model').val(this.dataset.model);
            $('#cc-model-id').val(this.dataset.modelId);
            $('#cc-key').val(this.dataset.key);
            $('#cc-type').val(this.dataset.type);

            const dataType = this.dataset.type || 'text';

            if (dataType === 'image' || dataType === 'video') {
                showMediaEditor(dataType);
            } else {
                showTextEditor();
            }

            $modal.show();
        });

        function showTextEditor() {
            $('#textEditor').show();
            $('#mediaEditor').hide();
            $('#editContentModal .modal-title').text('Editar contenido de texto');
            $value.val(currentEditable.innerText.trim());
        }

        function showMediaEditor(type) {
            $('#textEditor').hide();
            $('#mediaEditor').show();
            let title = 'Editar imagen';
            if (type === 'video') title = 'Editar video';
            else if (type === 'gif') title = 'Editar GIF animado';
            $('#editContentModal .modal-title').text(title);
            selectedFile = null;

            const currentSrc = currentEditable.src || currentEditable.getAttribute('data-src');
            if (currentSrc) {
                if (type === 'video') {
                    $('#currentMediaPreview').html(`<video controls style="width: 100%; max-height: 200px; background: #000;"><source src="${currentSrc}" type="video/mp4"></video>`);
                } else {
                    $('#currentMediaPreview').html(`<img src="${currentSrc}" alt="media preview" class="img-fluid" style="max-height: 150px; max-width: 100%;">`);
                }
            } else {
                $('#currentMediaPreview').html('<p class="text-muted mb-0">No hay archivo asignado</p>');
            }

            // Bootstrap 5 tab show
            let tab = new bootstrap.Tab(document.querySelector('#existing-tab'))
            tab.show();

            loadExistingFiles(type);
        }

        function loadExistingFiles(type) {
            const model = $('#cc-model').val();
            $('#filesGrid').html(`<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div><p class="text-muted mt-2 mb-0">Cargando archivos...</p></div>`);

            fetch(`/public/media/list?type=${type}&category=${model}`, { headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') } })
            .then(res => res.ok ? res.json() : Promise.reject('Error al cargar archivos'))
            .then(data => {
                if (data.files && data.files.length > 0) {
                    renderFilesGrid(data.files, type);
                } else {
                    $('#filesGrid').html(`<div class="col-12 text-center py-5"><i class="bi bi-folder2-open" style="font-size: 3rem; color: #6c757d;"></i><p class="text-muted mt-3 mb-0">No hay archivos</p></div>`);
                }
            })
            .catch(error => {
                $('#filesGrid').html(`<div class="col-12 text-center py-4"><i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i><p class="text-danger mt-2 mb-0">Error</p></div>`);
            });
        }

        function renderFilesGrid(files, type) {
            let html = files.map(file => {
                let mediaTag = `<img src="${file.url}" alt="${file.name}" class="img-fluid" style="width: 100%; height: 120px; object-fit: cover;">`;
                if(type === 'video') {
                     mediaTag = `<video src="${file.url}" style="width: 100%; height: 120px; object-fit: cover;"></video>`;
                }
                return `
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="card file-card h-100" style="cursor: pointer;" data-file='${JSON.stringify(file)}'>
                            <div class="card-body p-2">${mediaTag}
                                <small class="d-block mt-2 text-truncate" title="${file.name}">${file.name}</small>
                            </div>
                        </div>
                    </div>`;
            }).join('');
            $('#filesGrid').html(html);

            $('.file-card').on('click', function() {
                $('.file-card').removeClass('border-primary').css('border-width', '1px');
                $(this).addClass('border-primary').css('border-width', '3px');
                selectedFile = JSON.parse($(this).attr('data-file'));
            });
        }

        $('#mediaFileInput, #dropZone').on('change drop', function(e){
            const file = e.type === 'drop' ? e.originalEvent.dataTransfer.files[0] : e.target.files[0];
            if(!file) return;
            e.preventDefault();
            e.stopPropagation();
            showNewFilePreview(file);
        });
        
        $('#dropZone').on('dragover', (e) => { e.preventDefault(); e.stopPropagation(); $(this).addClass('border-primary'); });
        $('#dropZone').on('dragleave', (e) => { e.preventDefault(); e.stopPropagation(); $(this).removeClass('border-primary'); });

        function showNewFilePreview(file) {
            const reader = new FileReader();
            reader.onload = e => {
                let mediaTag = file.type.startsWith('video/')
                    ? `<video src="${e.target.result}" controls class="img-fluid" style="max-height: 250px;"></video>`
                    : `<img src="${e.target.result}" alt="Preview" class="img-fluid" style="max-height: 250px;">`;
                $('#newMediaPreview').show().find('> div').html(`${mediaTag}<small class="d-block mt-2 text-muted">${file.name}</small>`);
                uploadFile(file);
            };
            reader.readAsDataURL(file);
        }

        function uploadFile(file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', $('#cc-type').val());
            formData.append('category', $('#cc-model').val());

            $('#uploadProgress').show();
            const $progressBar = $('#uploadProgress .progress-bar');

            fetch('/public/media/upload', { method: 'POST', headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') }, body: formData })
            .then(res => res.ok ? res.json() : Promise.reject('Error al subir'))
            .then(data => {
                $progressBar.css('width', '100%');
                setTimeout(() => { $('#uploadProgress').hide(); $progressBar.css('width', '0%'); }, 500);
                selectedFile = { path: data.path, url: data.url, name: file.name, size: file.size, type: file.type };
                alert('Archivo subido. Haz clic en "Guardar cambios".');
            })
            .catch(error => {
                $('#uploadProgress').hide();
                alert('Error al subir archivo.');
            });
        }

        $('#saveContentBtn').on('click', () => {
            const contentType = $('#cc-type').val();
            if (contentType === 'image' || contentType === 'video') {
                saveMediaContent();
            } else {
                saveTextContent();
            }
        });

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
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
                body: JSON.stringify(payload)
            })
            .then(res => res.ok ? res.json() : Promise.reject('Error al guardar'))
            .then(() => {
                if (currentEditable) currentEditable.innerText = payload.value;
                $modal.hide();
                alert('Contenido actualizado');
            })
            .catch((error) => alert('Error: ' + error.message));
        }

        function saveMediaContent() {
            if (!selectedFile) {
                alert('Selecciona un archivo.');
                return;
            }

            const payload = {
                model: $('#cc-model').val(),
                model_id: $('#cc-model-id').val(),
                key: $('#cc-key').val(),
                type: $('#cc-type').val(),
                file_path: selectedFile.path,
                metadata: { url: selectedFile.url, name: selectedFile.name, size: selectedFile.size, mime_type: selectedFile.type }
            };

            fetch('/public/media/store', {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
                body: JSON.stringify(payload)
            })
            .then(res => res.ok ? res.json() : Promise.reject('Error al guardar media'))
            .then(() => {
                if (currentEditable) {
                    if(currentEditable.tagName === 'IMG') currentEditable.src = selectedFile.url;
                    if(currentEditable.tagName === 'VIDEO') {
                        let source = currentEditable.querySelector('source');
                        if(source) source.src = selectedFile.url;
                        currentEditable.load();
                    }
                }
                $modal.hide();
                alert('Multimedia actualizada');
            })
            .catch((error) => alert('Error: ' + error.message));
        }
    });
    </script>
    @endcan
</body>

</html>
