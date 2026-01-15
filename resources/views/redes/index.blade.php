@extends('layouts.app')

@section('title', 'Redes')

@section('content')

<section>
    {{-- Esta es la seccion del titulo de la vista index --}}
    <h1 class="text-center font-weight-bold mb-3">Gestión Redes</h1>
</section>

<section>
    <div class="container">
        {{-- seccion de botones de accion --}}

        <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar Red</a>

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
                    <th>Descripciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de descripciones --}}</td>
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