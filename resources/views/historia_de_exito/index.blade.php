@extends('layouts.app')

@section('title', 'Historias de éxito')

@section('content')

<section>
    {{-- Esta es la seccion del titulo de la vista index --}}
    <h1 class="text-center font-weight-bold mb-3">gestion de Historias de Éxito</h1>
</section>

<section>
    <div class="container">
        {{-- seccion de botones de accion --}}

        <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar Historia</a>

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
                    <th>Nombre </th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Año</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de id --}}</td>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de titulo --}}</td>
                    <td>{{-- logica de descripcion --}}</td>
                    <td>{{-- logica de año --}}</td>
                    <td>{{-- logica de correo --}}</td>
                    <td>
                        {{-- configurar logica de acciones --}}
                    </td>
                </tr>
                {{-- Agregar mas filas segun los datos disponibles --}}
            </tbody>
        </table>
    </div>
</section>

@endsection