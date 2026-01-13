@extends('layouts.app')

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

<section>
    <div class="container mt-4">
        {{-- seccion de tabla de datos --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Competencia</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de id --}}</td>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de descripcion --}}</td>
                    <td>{{-- se debe agregar botones eliminar y editar--}}</td>   
                    </tr>
                {{-- Agregar mas filas segun los datos disponibles --}}
            </tbody>
        </table>
    </div>
</section>

@endsection