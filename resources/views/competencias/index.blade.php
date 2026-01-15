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
        @can('competencias.create')
            <a href="{{-- enlace al controller --}}" class="btn btn-success">Agregar Competencia</a>
        @endcan
        <a href="{{-- enlace al controller --}}" class="btn btn-primary">Volver</a>
    </div>
</section>

<section>
    <div class="container mt-4">
        {{-- seccion de tabla de datos --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre de la Competencia</th>
                    <th>Descripcion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ejemplo de fila de datos --}}
                <tr>
                    <td>{{-- logica de nombre --}}</td>
                    <td>{{-- logica de descripcion --}}</td>
                    <td>
                        @can('competencias.view')
                            <a href="{{-- enlace show --}}" class="btn btn-info btn-sm" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endcan

                        @can('competencias.edit')
                            <a href="{{-- enlace edit --}}" class="btn btn-primary btn-sm" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endcan

                        @can('competencias.delete')
                            <form action="{{-- enlace delete --}}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar competencia?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                    </tr>
                {{-- Agregar mas filas segun los datos disponibles --}}
            </tbody>
        </table>
    </div>
</section>

@endsection