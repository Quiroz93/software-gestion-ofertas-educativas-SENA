@extends('adminlte::page')

@section('title', 'Competencias')

@section('content')

<section>
    {{-- Esta es la seccion del titulo de la vista index --}}
    <h1 class="text-center font-weight-bold mb-3">gestion de competencias</h1>
</section>

<section>
    <div class="container">
        {{-- seccion de botones de accion --}}
        <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar Competencia</a>
        <a href="{{-- enlace al controller --}}" class="btn btn-primary">Volver</a>
    </div>
</section>

@endsection