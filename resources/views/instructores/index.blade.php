@extends('layouts.app')

@section('title', 'Historias de éxito')

@section('content')

<section>
    {{-- Esta es la seccion del titulo de la vista index --}}
    <h1 class="text-center font-weight-bold mb-3">gestion de Instructores</h1>
</section>

<section>
    <div class="container">
        {{-- seccion de botones de accion --}}

        <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar instructor</a>

        <a href="{{-- enlace al controller --}}" class="btn btn-secondary">Volver</a>
    </div>
</section>

<section>
    <div class="container mt-4">
        {{-- seccion de tabla de datos --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre </th>
                    <th>Apellido</th>
                    <th>Perfil</th>
                    <th>Experiencia</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de apellido --}}</td>
                    <td>{{-- logica de perfil --}}</td>
                    <td>{{-- logica de experiencia --}}</td>
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