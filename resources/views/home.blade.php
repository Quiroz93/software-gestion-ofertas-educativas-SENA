@extends('layouts.public')

@section('title', 'Dashboard')

@section('content_header')
<div class="row mb-3" style="font-family: 'worksans sans-serif';">
  <div class="d-flex align-items-center gap-2 text-warning">
    <i class="fas fa-home text-primary fs-4"></i>
    <h2 class="mb-0 fw-semibold text-xl text-gray-800 editable"
    data-model="home"
        data-model-id="1"
        data-key="home_title"
        data-type="text">
        {{ getCustomContent('home', 'home_title', 'Home') }}
    </h2>
  </div>
</div>
<div class="row mb-2">
  <div class="col-6" style="font-family: 'worksans sans-serif';">
    <h1 style="color:#39A900">
      <span class="text-bold text-primary editable"
        data-model="home"
        data-model-id="0"
        data-key="bienvenidos_title"
        data-type="text">
        {{ getCustomContent('bienvenidos', 'bienvenidos_title', 'Welcome') }}
      </span>, {{ auth()->user()->name }}
    </h1>
  </div>
  <div class="col-6 d-flex justify-content-end align-items-end">
    <a class="link-secondary mt-3" href="#" aria-label="Search">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="20"
        height="20"
        fill="none"
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        class="mx-3"
        role="img"
        viewBox="0 0 24 24">
        <title>Search</title>
        <circle cx="10.5" cy="10.5" r="7.5"></circle>
        <path d="M21 21l-5.2-5.2"></path>
      </svg>
    </a>
  </div>
</div>


@endsection

@section('content')

{{-- Encabezado principal --}}
<div class="container" >
  @php
    $heroBgPath = getCustomContent('home', 'hero_background', null);
    $heroBgUrl = $heroBgPath ? asset('storage/' . $heroBgPath) : asset('images/background_1.png');
  @endphp
  <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis editable" 
       data-model="home" 
       data-model-id="0" 
       data-key="hero_background" 
       data-type="image"
       style="background-image: url('{{ $heroBgUrl }}'); background-size:cover">
    <div class="row">
      <div class="col-lg-6 px-0">
        <h1 class="display-4 text-bold editable" style="color: #39A900; font-family: 'worksans sans-serif'; font-style:italic;"
          data-model="home" data-model-id="0" data-key="hero_title" data-type="text">
          {!! getCustomContent('home', 'hero_title', 'Title of a longer featured blog post') !!}
        </h1>
        <p class="lead my-3 text-light editable" style="font-family: 'worksans sans-serif';"
          data-model="home" data-model-id="0" data-key="hero_description" data-type="text">
          {!! getCustomContent('home', 'hero_description', 'Multiple lines of text that form the lede, informing new readers quickly and efficiently about what\'s most interesting in this post\'s contents.') !!}
        </p>
        <p class="lead mb-0">
          <a href="#" class="text-body-emphasis fw-bold text-success text-decoration-underline editable" style="font-family: worksans;"
            data-model="home" data-model-id="0" data-key="hero_link_text" data-type="text">
            {!! getCustomContent('home', 'hero_link_text', 'Continue reading>>>') !!}
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
{{-- fin encabezado principal --}}



{{-- Carrusel de imágenes --}}
<div class="container my-4 container-fluid">
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" style="height: 400px;"> {{-- tamaño temporal. --}}
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        @php
          $slide1ImagePath = getCustomContent('home', 'carousel_slide1_image', null);
          $slide1ImageUrl = $slide1ImagePath ? asset('storage/' . $slide1ImagePath) : asset('images/carousel-placeholder.jpg');
        @endphp
        <img src="{{ $slide1ImageUrl }}" class="d-block w-100 editable" alt="Slide 1"
             data-model="home" data-model-id="0" data-key="carousel_slide1_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide1_title" data-type="text">
            {!! getCustomContent('home', 'carousel_slide1_title', 'First slide label') !!}
          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide1_desc" data-type="text">
            {!! getCustomContent('home', 'carousel_slide1_desc', 'Some representative placeholder content for the first slide.') !!}
          </p>
        </div>
      </div>
      <div class="carousel-item">
        @php
          $slide2ImagePath = getCustomContent('home', 'carousel_slide2_image', null);
          $slide2ImageUrl = $slide2ImagePath ? asset('storage/' . $slide2ImagePath) : asset('images/carousel-placeholder.jpg');
        @endphp
        <img src="{{ $slide2ImageUrl }}" class="d-block w-100 editable" alt="Slide 2"
             data-model="home" data-model-id="0" data-key="carousel_slide2_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide2_title" data-type="text">
            {!! getCustomContent('home', 'carousel_slide2_title', 'Second slide label') !!}
          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide2_desc" data-type="text">
            {!! getCustomContent('home', 'carousel_slide2_desc', 'Some representative placeholder content for the second slide.') !!}
          </p>
        </div>
      </div>
      <div class="carousel-item">
        @php
          $slide3ImagePath = getCustomContent('home', 'carousel_slide3_image', null);
          $slide3ImageUrl = $slide3ImagePath ? asset('storage/' . $slide3ImagePath) : asset('images/carousel-placeholder.jpg');
        @endphp
        <img src="{{ $slide3ImageUrl }}" class="d-block w-100 editable" alt="Slide 3"
             data-model="home" data-model-id="0" data-key="carousel_slide3_image" data-type="image">
        <div class="carousel-caption d-none d-md-block">
          <h5 class="editable" data-model="home" data-model-id="0" data-key="carousel_slide3_title" data-type="text">
            {!! getCustomContent('home', 'carousel_slide3_title', 'Third slide label') !!}
          </h5>
          <p class="editable" data-model="home" data-model-id="0" data-key="carousel_slide3_desc" data-type="text">
            {!! getCustomContent('home', 'carousel_slide3_desc', 'Some representative placeholder content for the third slide.') !!}
          </p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>
{{-- fin carrusel de imágenes--}}

{{-- Posts destacados --}}
<div class="container" style="font-family: 'worksans sans-serif';">
  <div class="row mb-2">
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary-emphasis editable"
            data-model="home" data-model-id="0" data-key="post1_category" data-type="text">
            {!! getCustomContent('home', 'post1_category', 'World') !!}
          </strong>
          <h3 class="mb-0 editable" data-model="home" data-model-id="0" data-key="post1_title" data-type="text">
            {!! getCustomContent('home', 'post1_title', 'Featured post') !!}
          </h3>
          <div class="mb-1 text-body-secondary editable" data-model="home" data-model-id="0" data-key="post1_date" data-type="text">
            {!! getCustomContent('home', 'post1_date', 'Nov 12') !!}
          </div>
          <p class="card-text mb-auto editable" data-model="home" data-model-id="0" data-key="post1_desc" data-type="text">
            {!! getCustomContent('home', 'post1_desc', 'This is a wider card with supporting text below as a natural lead-in to additional content.') !!}
          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link text-success text-decoration-underline editable"
            data-model="home"
            data-model-id="0"
            data-key="featured_post1_link"
            data-type="text">
            {{ getCustomContent('home', 'featured_post1_link', 'Continue reading') }}
            <svg class="bi" aria-hidden="true">
              <use xlink:href="#chevron-right"></use>
            </svg>
          </a>
        </div>
        <div class="col-auto d-none d-lg-block editable" data-model="home" data-model-id="0" data-key="post1_image" data-type="image">
          <svg
            aria-label="Placeholder: Thumbnail"
            class="bd-placeholder-img"
            height="250"
            preserveAspectRatio="xMidYMid slice"
            role="img"
            width="200"
            xmlns="http://www.w3.org/2000/svg">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success-emphasis editable"
            data-model="home" data-model-id="0" data-key="post2_category" data-type="text">
            {!! getCustomContent('home', 'post2_category', 'Design') !!}
          </strong>
          <h3 class="mb-0 editable" data-model="home" data-model-id="0" data-key="post2_title" data-type="text">
            {!! getCustomContent('home', 'post2_title', 'Post title') !!}
          </h3>
          <div class="mb-1 text-body-secondary editable" data-model="home" data-model-id="0" data-key="post2_date" data-type="text">
            {!! getCustomContent('home', 'post2_date', 'Nov 11') !!}
          </div>
          <p class="mb-auto editable" data-model="home" data-model-id="0" data-key="post2_desc" data-type="text">
            {!! getCustomContent('home', 'post2_desc', 'This is a wider card with supporting text below as a natural lead-in to additional content.') !!}
          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link text-success text-decoration-underline editable"
            data-model="home"
            data-model-id="0"
            data-key="featured_post2_link"
            data-type="text">
            {{ getCustomContent('home', 'featured_post2_link', 'Continue reading') }}
            <svg class="bi" aria-hidden="true">
              <use xlink:href="#chevron-right"></use>
            </svg>
          </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <svg
            aria-label="Placeholder: Thumbnail"
            class="bd-placeholder-img"
            height="250"
            preserveAspectRatio="xMidYMid slice"
            role="img"
            width="200"
            xmlns="http://www.w3.org/2000/svg">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c"></rect>
            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- fin posts destacados --}}

<div class="container" style="font-family: 'worksans sans-serif';">
  <section>
    <div class="d-flex align-items-center mb-3 mt-4">
      <i class="fas fa-layer-group text-success fa-2x me-2 mt-4 mb-4"></i>
      <h4 class="fw-bold mb-0 editable"
          data-model="home"
          data-model-id="0"
          data-key="modules_section_title"
          data-type="text">
        {{ getCustomContent('home', 'modules_section_title', 'Información y Módulos') }}
      </h4>
    </div>
    <hr>

    <div class="row g-4">

      {{-- Centros --}}
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            @can('centros.view')
            <a href="{{ route('centros.index') }}"><i class="bi bi-building fa-2x text-primary mb-2"></i></a>
            @else
            <a href="{{ route('public.centros.index') }}"><i class="bi bi-building fa-2x text-primary mb-2"></i></a>
            @endcan
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="centros_title"
                data-type="text">
              {{ getCustomContent('home', 'centros_title', 'Centros') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="centros_description"
               data-type="text">
              {{ getCustomContent('home', 'centros_description', 'Centros de formación.') }}
            </p>
          </div>
        </div>
      </div>

      {{-- Programas --}}
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            @can('programas.view')
            <a href="{{ route('programas.index') }}"><i class="bi bi-journal-bookmark fa-2x text-success mb-2"></i></a>
            @else
            <a href="{{ route('public.programas.index') }}"><i class="bi bi-journal-bookmark fa-2x text-success mb-2"></i></a>
            @endcan
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="programas_title"
                data-type="text">
              {{ getCustomContent('home', 'programas_title', 'Programas') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="programas_description"
               data-type="text">
              {{ getCustomContent('home', 'programas_description', 'Programas educativos.') }}
            </p>
          </div>
        </div>
      </div>

      {{-- Ofertas --}}
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            @can('ofertasEducativas.view')
            <a href="{{ route('ofertasEducativas.index') }}"><i class="bi bi-mortarboard fa-2x text-warning mb-2"></i></a>
            @else
            <a href="{{ route('public.ofertasEducativas.index') }}"><i class="bi bi-mortarboard fa-2x text-warning mb-2"></i></a>
            @endcan

            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="ofertas_title"
                data-type="text">
              {{ getCustomContent('home', 'ofertas_title', 'Ofertas') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="ofertas_description"
               data-type="text">
              {{ getCustomContent('home', 'ofertas_description', 'Ofertas educativas vigentes.') }}
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
            @can('instructores.view')
            <a href="{{ route('instructores.index') }}"><i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i></a>
            @else
            <a href="{{ route('public.instructores.index') }}"><i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i></a>
            @endcan
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="instructores_title"
                data-type="text">
              {{ getCustomContent('home', 'instructores_title', 'Instructores') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="instructores_description"
               data-type="text">
              {{ getCustomContent('home', 'instructores_description', 'Perfil de nuestros instructores') }}
            </p>
          </div>
        </div>
      </div>

      {{-- Historias --}}
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            @can('historias_de_exito.view')
            <a href="{{ route('historias_de_exito.index') }}"><i class="fas fa-book-open fa-2x text-warning mb-2"></i></a>
            @else
            <a href="{{ route('public.historiasDeExito.index') }}"><i class="fas fa-book-open fa-2x text-warning mb-2"></i></a>
            @endcan
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="historias_title"
                data-type="text">
              {{ getCustomContent('home', 'historias_title', 'Historias') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="historias_description"
               data-type="text">
              {{ getCustomContent('home', 'historias_description', 'Conoce las experiencias que se viven en el Centro Agroempresarial y Turístico de los Andes') }}
            </p>
          </div>
        </div>
      </div>

      {{-- Modelos a seguir --}}
      <div class="col-md-3">
        <div class="card h-100 shadow-sm border-0 text-center">
          <div class="card-body">
            <a href=""><i class="bi bi-award  fa-2x text-primary mb-2"></i></a>
            <h6 class="fw-bold editable"
                data-model="home"
                data-model-id="0"
                data-key="reconocimientos_title"
                data-type="text">
              {{ getCustomContent('home', 'reconocimientos_title', 'Reconocimientos') }}
            </h6>
            <p class="text-muted small editable"
               data-model="home"
               data-model-id="0"
               data-key="reconocimientos_description"
               data-type="text">
              {!! getCustomContent('home', 'reconocimientos_description', 'Conoce a nuestros aprendices mas destacados e inspirate a ser parte de nustra <span class="fw-bold mb-0">FAMILIA CATA</span>') !!}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div style="font-family: 'worksans sans-serif';">
  <main class="container py-4">
    <div class="row mb-2">
      <div class="col">
        <h1 class="display-4 editable" data-model="home" data-model-id="0" data-key="blog_title" data-type="text">
          {!! getCustomContent('home', 'blog_title', 'Blog Home Page') !!}
        </h1>
        <p class="lead text-body-secondary editable" data-model="home" data-model-id="0" data-key="blog_description" data-type="text">
          {!! getCustomContent('home', 'blog_description', 'An example blog homepage built with Bootstrap 5') !!}
        </p>
      </div>
    </div>

    <div class="row g-5">
        <div class="col-md-8">
          <h3 class="pb-4 mb-4 fst-italic border-bottom editable" data-model="home" data-model-id="0" data-key="article1_subtitle" data-type="text">
            {!! getCustomContent('home', 'article1_title', 'From the Firehose' ) !!}</h3>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article1_title" data-type="text">
              {!! getCustomContent('home', 'article1_title', 'Sample blog post') !!}
            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article1_meta" data-type="text">
              {!! getCustomContent('home', 'article1_meta', 'January 1, 2021 by <a href="#">Mark</a>') !!}
            </p>
            <p class=" editable" data-model="home" data-model-id="0" data-key="article1_parrafo1" data-type="text">
              {{ getCustomContent('home', 'article1_parrafo1','This blog post shows a few different types of content that’s
              supported and styled with Bootstrap. Basic typography, lists,
              tables, images, code, and more are all supported as expected.')}}
            </p>
            <hr />
            <p class="editable" data-model="home" data-model-id="0" data-key="article1_parrafo2" data-type="text">
              {{ getCustomContent('home', 'article1_parrafo2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We´ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.') }}
            </p>
            <h2 class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes"
              data-type="text">{{ getCustomContent('home', 'article1_blockquotes', 'Blockquotes') }}</h2>
            <p class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes_p"
              data-type="text">
              {{ getCustomContent('home', 'article1_blockquotes_p', 'This is an example blockquote in action:') }}
            </p>
            <blockquote class="blockquote">
              <p class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_blockquotes_p1"
                data-type="text">{{getCustomContent('home', 'article1_blockquotes_p1', 'Quoted text goes here.')}}</p>
            </blockquote>
            <p class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_blockquotes_p2"
              data-type="text">
              {{ getCustomContent('home', 'article1_blockquotes_p2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We´ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.') }}
            </p>
            <h3 class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_subtitle2"
              data-type="text">
              {{getCustomContent('home', 'article1_subtitle2', 'Example lists')}}
            </h3>
            <p
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_parrafo3"
              data-type="text">
              {{ getCustomContent('home', 'article1_parrafo3', 'This is some additional paragraph placeholder content. It´s a
            slightly shorter version of the other highly repetitive body text
            used throughout. This is an example unordered list:') }}
            </p>
            <ul>
              <li
                class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item1"
                data-type="text">
                {{ getCustomContent('home', 'article1_item1', 'First list item') }}
              </li>
              <li class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item2"
                data-type="text">
                {{ getCustomContent('home', 'article1_item2', 'Second list item with a longer description') }}
              </li>
              <li class="editable"
                data-model="home"
                data-model-id="0"
                data-key="article1_item3"
                data-type="text">{{ getCustomContent('home', 'article1_item3', 'Third list item to close it out') }}</li>
            </ul>
            <p
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_listP"
              data-type="text">{{ getCustomContent('home', 'article1_listp', 'And this is an ordered list:') }}</p>
            <ol>
              <li
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_oitem1"
              data-type="text">{{ getCustomContent('home', 'article1_oitem1', 'First list item') }}</li>
              <li
              class="editable"
              data-model="home"
              data-model-id="0"
              data-key="article1_oitem2"
              data-type="text">{{ getCustomContent('home', 'article1_oitem2', 'Second list item with a longer description') }}</li>
              <li>Third list item to close it out</li>
            </ol>
            <p>And this is a definition list:</p>
            <dl>
              <dt>HyperText Markup Language (HTML)</dt>
              <dd>
                The language used to describe and define the content of a Web
                page
              </dd>
              <dt>Cascading Style Sheets (CSS)</dt>
              <dd>Used to describe the appearance of Web content</dd>
              <dt>JavaScript (JS)</dt>
              <dd>
                The programming language used to build advanced Web sites and
                applications
              </dd>
            </dl>
            <h2>Inline HTML elements</h2>
            <p>
              HTML defines a long list of available inline tags, a complete list
              of which can be found on the
              <a
                href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element">Mozilla Developer Network</a>.
            </p>
            <ul>
              <li>
                <strong>To bold text</strong>, use
                <code class="language-plaintext highlighter-rouge">&lt;strong&gt;</code>.
              </li>
              <li>
                <em>To italicize text</em>, use
                <code class="language-plaintext highlighter-rouge">&lt;em&gt;</code>.
              </li>
              <li>
                Abbreviations, like
                <abbr title="HyperText Markup Language">HTML</abbr> should use
                <code class="language-plaintext highlighter-rouge">&lt;abbr&gt;</code>, with an optional
                <code class="language-plaintext highlighter-rouge">title</code>
                attribute for the full phrase.
              </li>
              <li>
                Citations, like <cite>— Mark Otto</cite>, should use
                <code class="language-plaintext highlighter-rouge">&lt;cite&gt;</code>.
              </li>
              <li>
                <del>Deleted</del> text should use
                <code class="language-plaintext highlighter-rouge">&lt;del&gt;</code>
                and <ins>inserted</ins> text should use
                <code class="language-plaintext highlighter-rouge">&lt;ins&gt;</code>.
              </li>
              <li>
                Superscript <sup>text</sup> uses
                <code class="language-plaintext highlighter-rouge">&lt;sup&gt;</code>
                and subscript <sub>text</sub> uses
                <code class="language-plaintext highlighter-rouge">&lt;sub&gt;</code>.
              </li>
            </ul>
            <p>
              Most of these elements are styled by browsers with few
              modifications on our part.
            </p>
            <h2>Heading</h2>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <h3>Sub-heading</h3>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <pre><code>Example code block</code></pre>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article2_title" data-type="text">
              {!! getCustomContent('home', 'article2_title', 'Another blog post') !!}
            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article2_meta" data-type="text">
              {!! getCustomContent('home', 'article2_meta', 'December 23, 2020 by <a href="#">Jacob</a>') !!}
            </p>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_content" data-type="text">
              {!! getCustomContent('home', 'article2_content', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.') !!}
            </p>
            <blockquote class="editable" data-model="home" data-model-id="0" data-key="article2_quote" data-type="text">
              <p>
                Longer quote goes here, maybe with some
                <strong>emphasized text</strong> in the middle of it.
              </p>
            </blockquote>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_additional_content" data-type="text">
              {!! getCustomContent('home', 'article2_additional_content', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.') !!}
            </p>
            <p class="editable" data-model="home" data-model-id="0" data-key="article2_additional_content2" data-type="text">
              {!! getCustomContent('home', 'article2_additional_content2', 'This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet of text affects the surrounding content. We\'ll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.') !!}
            </p>
            <h3>Example table</h3>
            <p>And don't forget about tables in these posts:</p>
            <table class="table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Upvotes</th>
                  <th>Downvotes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Alice</td>
                  <td>10</td>
                  <td>11</td>
                </tr>
                <tr>
                  <td>Bob</td>
                  <td>4</td>
                  <td>3</td>
                </tr>
                <tr>
                  <td>Charlie</td>
                  <td>7</td>
                  <td>9</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Totals</td>
                  <td>21</td>
                  <td>23</td>
                </tr>
              </tfoot>
            </table>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1 editable" data-model="home" data-model-id="0" data-key="article3_title" data-type="text">
              {!! getCustomContent('home', 'article3_title', 'New feature') !!}
            </h2>
            <p class="blog-post-meta editable" data-model="home" data-model-id="0" data-key="article3_meta" data-type="text">
              {!! getCustomContent('home', 'article3_meta', 'December 14, 2020 by <a href="#">Chris</a>') !!}
            </p>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <ul>
              <li>First list item</li>
              <li>Second list item with a longer description</li>
              <li>Third list item to close it out</li>
            </ul>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout.
            </p>
          </article>
          <nav class="blog-pagination" aria-label="Pagination">
            <a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
            <a
              class="btn btn-outline-secondary rounded-pill disabled"
              aria-disabled="true">Newer</a>
          </nav>
        </div>
        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem">
            <div class="p-4 mb-3 bg-body-tertiary rounded text-success">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_about_title" data-type="text">
                {!! getCustomContent('home', 'sidebar_about_title', 'About') !!}
              </h4>
              <p class="mb-0 editable" data-model="home" data-model-id="0" data-key="sidebar_about_text" data-type="text">
                {!! getCustomContent('home', 'sidebar_about_text', 'Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.') !!}
              </p>
            </div>
            <div>
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_recent_title" data-type="text">
                {!! getCustomContent('home', 'sidebar_recent_title', 'Recent posts') !!}
              </h4>
              <ul class="list-unstyled">
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">Example blog post title</h6>
                      <small class="text-body-secondary">January 15, 2024</small>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">This is another blog post title</h6>
                      <small class="text-body-secondary">January 14, 2024</small>
                    </div>
                  </a>
                </li>
                <li>
                  <a
                    class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                    href="#">
                    <svg
                      aria-hidden="true"
                      class="bd-placeholder-img"
                      height="96"
                      preserveAspectRatio="xMidYMid slice"
                      width="100%"
                      xmlns="http://www.w3.org/2000/svg">
                      <rect width="100%" height="100%" fill="#777"></rect>
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">
                        Longer blog post title: This one has multiple lines!
                      </h6>
                      <small class="text-body-secondary">January 13, 2024</small>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="p-4">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_archives_title" data-type="text">
                {!! getCustomContent('home', 'sidebar_archives_title', 'Archives') !!}
              </h4>
              <ol class="list-unstyled mb-0">
                <li><a href="#">March 2021</a></li>
                <li><a href="#">February 2021</a></li>
                <li><a href="#">January 2021</a></li>
                <li><a href="#">December 2020</a></li>
                <li><a href="#">November 2020</a></li>
                <li><a href="#">October 2020</a></li>
                <li><a href="#">September 2020</a></li>
                <li><a href="#">August 2020</a></li>
                <li><a href="#">July 2020</a></li>
                <li><a href="#">June 2020</a></li>
                <li><a href="#">May 2020</a></li>
                <li><a href="#">April 2020</a></li>
              </ol>
            </div>
            <div class="p-4">
              <h4 class="fst-italic editable" data-model="home" data-model-id="0" data-key="sidebar_elsewhere_title" data-type="text">
                {!! getCustomContent('home', 'sidebar_elsewhere_title', 'Elsewhere') !!}
              </h4>
              <ol class="list-unstyled">
                <li><a href="#">GitHub</a></li>
                <li><a href="#">Social</a></li>
                <li><a href="#">Facebook</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
  </main>
</div>

{{-- FOOTER --}}
<footer class="bg-light py-5" style="font-family: 'worksans sans-serif';">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_centro_title" data-type="text">
          {!! getCustomContent('home', 'footer_centro_title', 'Centro') !!}
        </h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_centro_link1" data-type="text">{!! getCustomContent('home', 'footer_centro_link1', 'Sobre nosotros') !!}</a></li>
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_centro_link2" data-type="text">{!! getCustomContent('home', 'footer_centro_link2', 'Programas') !!}</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_servicios_title" data-type="text">
          {!! getCustomContent('home', 'footer_servicios_title', 'Servicios') !!}
        </h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_servicios_link1" data-type="text">{!! getCustomContent('home', 'footer_servicios_link1', 'Características') !!}</a></li>
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_servicios_link2" data-type="text">{!! getCustomContent('home', 'footer_servicios_link2', 'información') !!}</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_recursos_title" data-type="text">
          {!! getCustomContent('home', 'footer_recursos_title', 'Recursos') !!}
        </h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_recursos_link1" data-type="text">{!! getCustomContent('home', 'footer_recursos_link1', 'Blog') !!}</a></li>
          <li><a href="#" class="text-decoration-none text-muted editable" data-model="home" data-model-id="0" data-key="footer_recursos_link2" data-type="text">{!! getCustomContent('home', 'footer_recursos_link2', 'Centro de ayuda') !!}</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5 class="editable" data-model="home" data-model-id="0" data-key="footer_contacto_title" data-type="text">
          {!! getCustomContent('home', 'footer_contacto_title', 'Contactanos') !!}
        </h5>
        <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_direccion" data-type="text">
          {!! getCustomContent('home', 'footer_contacto_direccion', 'Cra. 11 No. 13-13') !!}
        </p>
        <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_telefono" data-type="text">
          {!! getCustomContent('home', 'footer_contacto_telefono', 'Linea de atención: 018000 910270') !!}
        </p>
        <p class="text-muted editable" data-model="home" data-model-id="0" data-key="footer_contacto_email" data-type="text">
          {!! getCustomContent('home', 'footer_contacto_email', 'Email: servicioalciudadano@sena.udu.co') !!}
        </p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <p class="text-center text-muted border-top pt-3 editable" data-model="home" data-model-id="0" data-key="footer_copyright" data-type="text">
          {!! getCustomContent('home', 'footer_copyright', '&copy; 2026 SENA, Centro Agroempresarial y Turístico de los Andes.') !!}
        </p>
      </div>
    </div>
  </div>
</footer>

@endsection