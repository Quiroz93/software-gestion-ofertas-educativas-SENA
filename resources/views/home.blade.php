<x-app-layout>

    {{-- ================= HEADER ================= --}}
    <x-slot name="header">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-home text-primary fs-4"></i>
            <h2 class="mb-0 fw-semibold text-xl text-gray-800">
                {{ __('Home') }}
            </h2>
        </div>
    </x-slot>

    <div class="container my-4">

        {{-- ================= SELECTOR DE ROL (MINIMIZADO) ================= --}}
        <section class="mb-3">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-3">
                            <form method="POST" action="{{-- RUTA LOGICA --}}">
                                @csrf
                                <div class="mb-2">
                                    <select name="rol" class="form-select form-select-sm" required>
                                        <option value="">Rol</option>
                                        @foreach(auth()->user()->roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ ucfirst($role->name) }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-sm btn-outline-primary w-100">
                                    <i class="fas fa-eye me-1"></i>
                                    Visualizar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= CAROUSEL INSTITUCIONAL ================= --}}
        <section class="mb-5">
            <div id="homeCarousel" class="shadow-sm rounded overflow-hidden" data-bs-ride="carousel">

                
            </div>
        </section>

        {{-- Carousel --}}
                <div id="carouselExampleIndicators" class="carousel slide mb-5">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                    </div>

                    <div class="carousel-inner rounded">
                        <div class="carousel-item active">
                            <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 1">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 2">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('') }}" class="d-block w-100" alt="Imagen 3">
                        </div>
                    </div>

                    {{-- controles --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

        {{-- ================= MÓDULOS + NOTICIAS (UNIFICADOS) ================= --}}
        <section>
            <div class="d-flex align-items-center mb-3 mt-4">
                <i class="fas fa-layer-group text-success fs-4 me-2 mt-4 mb-4"></i>
                <h4 class="fw-bold mb-0">Información y Módulos</h4>
            </div>
            <hr>

            <div class="row g-4">

                {{-- Centros --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-building fs-2 text-primary mb-2"></i>
                            <h6 class="fw-bold">Centros</h6>
                            <p class="text-muted small">
                                Centros de formación.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Programas --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-journal-bookmark fs-2 text-success mb-2"></i>
                            <h6 class="fw-bold">Programas</h6>
                            <p class="text-muted small">
                                Programas educativos.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Ofertas --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold">Ofertas</h6>
                            <p class="text-muted small">
                                Ofertas educativas vigentes.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Noticias dinámicas --}}
                @foreach($noticias as $noticia)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="fw-bold">
                                <i class="bi bi-newspaper me-1 text-info"></i>
                                {{ $noticia->titulo }}
                            </h6>
                            <p class="text-muted small">
                                {{ Str::limit($noticia->descripcion, 90) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Instructores --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold">Instructores</h6>
                            <p class="text-muted small">
                                Perfil de nuestros instructores
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Historias --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold">Historias</h6>
                            <p class="text-muted small">
                                Conoce las experiencias que se viven en el Centro Agroempresarial y Turístico de los Andes
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Modelos a seguir --}}
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 text-center">
                        <div class="card-body">
                            <i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
                            <h6 class="fw-bold">Reconocimientos</h6>
                            <p class="text-muted small">
                                Conoce a nuestros aprendices mas destacados e inspirate a ser parte de nustra <span class="fw-bold mb-0">FAMILIA CATA</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>



</x-app-layout>
{{-- ================= FOOTER ================= --}}
<footer class="text-center py-4 text-white bg-dark mt-5">
    © {{ date('Y') }} SENA · Sistema de Gestión de Ofertas Educativas
</footer>