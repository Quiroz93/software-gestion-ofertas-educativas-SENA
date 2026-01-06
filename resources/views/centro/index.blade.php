@extends('adminlte::page')
@section('title')
Centros
@endsection
@section('content')
<x-app-layout>
    <div class="container-fluid">

        <h1 class="mt-4 mb-4">Lista de Centros</h1>


        @can('create_centros')
        <a href="{{ route('centro.create') }}" class="btn btn-success mt-4 mb-4">Agregar Centro</a>
        @endcan
        <a href="{{route('dashboard')}}" class="btn btn-primary mt-4 mb-4">Volver</a>

        <table class="table table-striped mt-2 mb-2">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- logica de foreach --}}
                @foreach ($centros as $centro)
                <tr>
                    <td>{{ $centro->id }}</td>
                    <td>{{ $centro->nombre }}</td>
                    <td>{{ $centro->direccion }}</td>
                    <td>{{ $centro->telefono }}</td>
                    <td>{{ $centro->correo }}</td>
                    <td>
                        <a href="{{ route('centro.edit', $centro->id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('centro.destroy', $centro->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="confirmarEliminacion(event)">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
@endsection