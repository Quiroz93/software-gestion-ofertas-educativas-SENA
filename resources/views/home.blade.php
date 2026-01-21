@extends('layouts.app')

@section('title', 'Dashboard')

@section('content_header')
<div class="row mb-3">
  <div class="d-flex align-items-center gap-2">
    <i class="fas fa-home text-primary fs-4"></i>
    <h2 class="mb-0 fw-semibold text-xl text-gray-800">
      {{ __('Home') }}
    </h2>
  </div>
</div>
<div class="row mb-2">
  <div class="col-6">
    <h1><Span>Bienvenido</Span>, {{ auth()->user()->name }}</h1>
  </div>
  <div class="col-6 d-flex justify-content-end align-items-rigth">
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

<div class="container container-fluid">
  <div class="row">
    <div class="col-12">
      {{-- header --}}
      <header class="border-bottom lh-1 py-3">
        <div class="row flex-nowrap justify-content-end align-items-end">
      </header>
    </div>
    <div class="nav-scroller py-1 mb-3 border-bottom">
      <nav class="nav nav-underline justify-content-between">
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">Competencias</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">inscribires</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">historias de exito</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">Instructores</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">nivel de formacion</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">Ofertas</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">Programas de formacion</a>
        <a class="nav-item nav-link link-body-emphasis text-light" href="#">Redes</a>
    </div>
    {{-- fin header --}}
  </div>
</div>


@endsection

@section('content')

{{-- Encabezado principal --}}
<div class="container" >
  <div class="p-4 p-md-5 mb-4 rounded text-body-emphasis " style="background-image: url('/images/background_1.png'); background-size:cover">
    <div class="row">
      <div class="col-lg-6 px-0" >
      <h1 class="display-4" style="color: #39A900; font-family: 'worksans', sans-serif; font-style:italic;">
        Title of a longer featured blog post
      </h1>
      <p class="lead my-3" style="color:white; font-family: calibri; font-style: italic;" >
        Multiple lines of text that form the lede, informing new readers
        quickly and efficiently about what’s most interesting in this post’s
        contents.
      </p>
      <p class="lead mb-0">
        <a href="#" class="text-body-emphasis fw-bold text-success text-decoration-underline" style="font-family: worksans;">Continue reading>>></a>
      </p>
    </div>
    <div class="col-lg-6 justify-content-end">
      <img src="images/DSC0478d4.png" alt="Imagen" class="" style="height:600px; width: auto;">
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
        <img src="..." class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="..." class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="..." class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
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
<div class="container">
  <div class="row mb-2">
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary-emphasis">World</strong>
          <h3 class="mb-0">Featured post</h3>
          <div class="mb-1 text-body-secondary">Nov 12</div>
          <p class="card-text mb-auto">
            This is a wider card with supporting text below as a natural
            lead-in to additional content.
          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link">
            Continue reading
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
    <div class="col-md-6">
      <div
        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-success-emphasis">Design</strong>
          <h3 class="mb-0">Post title</h3>
          <div class="mb-1 text-body-secondary">Nov 11</div>
          <p class="mb-auto">
            This is a wider card with supporting text below as a natural
            lead-in to additional content.
          </p>
          <a
            href="#"
            class="icon-link gap-1 icon-link-hover stretched-link">
            Continue reading
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

<div class="container">
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
            <a href="{{ route('public.programas.index') }}" class="btn btn-primary btn-lg"><i class="bi bi-mortarboard fs-2 text-warning mb-2"></i>
              Ver oferta educativa
            </a>

            
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
            <i class="fas fa-chalkboard-teacher fs-2 text-success mb-2"></i>
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
            <i class="fas fa-book-open fs-2 text-warning mb-2"></i>
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
            <i class="bi bi-award  fs-2 text-primary mb-2"></i>
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

<div class="container">
  <main class="container py-4">
    <div class="row mb-2">
      <div class="col">
        <h1 class="display-4">Blog Home Page</h1>
        <p class="lead text-body-secondary">
          An example blog homepage built with Bootstrap 5
        </p>
      </div>


      <div class="row g-5">
        <div class="col-md-8">
          <h3 class="pb-4 mb-4 fst-italic border-bottom">From the Firehose</h3>
          <article class="blog-post">
            <h2 class="display-5 link-body-emphasis mb-1">Sample blog post</h2>
            <p class="blog-post-meta">
              January 1, 2021 by <a href="#">Mark</a>
            </p>
            <p>
              This blog post shows a few different types of content that’s
              supported and styled with Bootstrap. Basic typography, lists,
              tables, images, code, and more are all supported as expected.
            </p>
            <hr />
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <h2>Blockquotes</h2>
            <p>This is an example blockquote in action:</p>
            <blockquote class="blockquote">
              <p>Quoted text goes here.</p>
            </blockquote>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <h3>Example lists</h3>
            <p>
              This is some additional paragraph placeholder content. It's a
              slightly shorter version of the other highly repetitive body text
              used throughout. This is an example unordered list:
            </p>
            <ul>
              <li>First list item</li>
              <li>Second list item with a longer description</li>
              <li>Third list item to close it out</li>
            </ul>
            <p>And this is an ordered list:</p>
            <ol>
              <li>First list item</li>
              <li>Second list item with a longer description</li>
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
            <h2 class="display-5 link-body-emphasis mb-1">Another blog post</h2>
            <p class="blog-post-meta">
              December 23, 2020 by <a href="#">Jacob</a>
            </p>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
            </p>
            <blockquote>
              <p>
                Longer quote goes here, maybe with some
                <strong>emphasized text</strong> in the middle of it.
              </p>
            </blockquote>
            <p>
              This is some additional paragraph placeholder content. It has been
              written to fill the available space and show how a longer snippet
              of text affects the surrounding content. We'll repeat it often to
              keep the demonstration flowing, so be on the lookout for this
              exact same string of text.
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
            <h2 class="display-5 link-body-emphasis mb-1">New feature</h2>
            <p class="blog-post-meta">
              December 14, 2020 by <a href="#">Chris</a>
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
              <h4 class="fst-italic">About</h4>
              <p class="mb-0">
                Customize this section to tell your visitors a little bit about
                your publication, writers, content, or something else entirely.
                Totally up to you.
              </p>
            </div>
            <div>
              <h4 class="fst-italic">Recent posts</h4>
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
              <h4 class="fst-italic">Archives</h4>
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
              <h4 class="fst-italic">Elsewhere</h4>
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
<footer class="bg-light py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5>Centro</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted">Sobre nosotros</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Programas</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Servicios</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted">Características</a></li>
          <li><a href="#" class="text-decoration-none text-muted">información</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Recursos</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted">Blog</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Centro de ayuda</a></li>
          <!-- more links -->
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Contactanos</h5>
        <p class="text-muted">Cra. 11 No. 13-13</p>
        <p class="text-muted">Linea de atención: 018000 910270</p>
        <p class="text-muted">Email: servicioalciudadano@sena.udu.co</p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <p class="text-center text-muted border-top pt-3">&copy; 2026 SENA, Centro Agroempresarial y Turístico de los Andes.</p>
      </div>
    </div>
  </div>
</footer>

@endsection