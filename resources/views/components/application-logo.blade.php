<a href="{{ route('dashboard') }}" class="brand-link">
    <span class="brand-image">
        {!! file_get_contents(public_path('images/logosimbolo-SENA.svg')) !!}
    </span>
    <span class="brand-text font-">SoeSoftware</span>
</a>

<style>
    .brand-link {
        font-family: 'Work Sans', sans-serif;
        display: flex;
        align-items: center;
        text-decoration: none;
        padding: 6px 0;
    }

    

    span.brand-image {
        display: flex;
        /* Usar flexbox para centrar */
        align-items: center;
        /* Centrar verticalmente */
        justify-content: center;
        /* Centrar el SVG dentro del contenedor */
        width: 40px;
        /* Ajusta el tamaño según sea necesario */
        height: 40px;
        /* Ajusta el tamaño según sea necesario */
        margin-right: 10px;
        /* Espacio entre la imagen y el texto */
    }

    .brand-image svg {
        width: 100%; /* Escalar el SVG al tamaño del contenedor */
        height: 100%; /* Escalar el SVG al tamaño del contenedor */
        color: #39A900; /* Verde SENA */
    }

    .brand-text {
        font-size: 1rem; /* Tamaño de fuente más grande */
        font-weight: 700; /* Negrita */
        color: #39A900; /* Verde SENA */
        font-family: 'Work Sans', sans-serif; /* Fuente personalizada */
        line-height: 1.2; /* Mejorar la legibilidad */
    }
</style>