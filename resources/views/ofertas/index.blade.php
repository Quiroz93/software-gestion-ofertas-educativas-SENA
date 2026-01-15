@extends('layouts.app')

@section('title', 'Ofertas')

@section('content')

<section>
    {{-- Esta es la seccion del titulo de la vista index --}}
    <h1 class="text-center font-weight-bold mb-3">Gestión de Ofetas</h1>
</section>

<section>
    <div class="container">
        {{-- seccion de botones de accion --}}

        <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar Oferta</a>

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
                    <th>Año</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de año --}}</td>
                    <td>{{-- logica de fecha inicio --}}</td>
                    <td>{{-- logica de fecha final --}}</td>
                    <td>{{-- logica de estado --}}</td>
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