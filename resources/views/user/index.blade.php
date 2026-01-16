@extends('layouts.app')

@section('title', 'Usuarios')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-users text-primary"></i>
        Usuarios del sistema
    </h1>

    <div>
        @can('users.create')
            <a href="{{ route('users.create') }}" class="btn btn-success">
                <i class="fas fa-user-plus"></i>
                Crear usuario
            </a>
        @endcan

        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>
</div>
@stop

@section('content')

@if($users->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        No hay usuarios registrados.
    </div>
@else

<div class="row">
@foreach($users as $u)
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fas fa-user"></i>
                    {{ $u->name }}
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <p class="mb-1">
                    <strong>ID:</strong>
                    <span class="badge badge-info">
                        {{ $u->id }}
                    </span>
                </p>

                <p class="mb-1">
                    <strong>Correo:</strong><br>
                    <a href="mailto:{{ $u->email }}">
                        {{ $u->email }}
                    </a>
                </p>

            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Lista de Usuarios</h3>
                </div>

                <div class="card-body">
                    @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $u)
                                <tr>
                                    <td><span class="badge badge-info">{{ $u->id }}</span></td>
                                    <td>{{ $u->name }}</td>
                                    <td><a href="mailto:{{ $u->email }}">{{ $u->email }}</a></td>

                                    <td>
                                        @can('users.edit')
                                        <a href="{{ route('users.edit', $u) }}" class="btn btn-warning ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px me-2 ms-2">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        @endcan
                                        @can('users.delete')
                                        <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirmarEliminacion(event);">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                        @can('users.view')
                                        <a href="{{ route('users.show', $u) }}" class="btn btn-info ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endcan

                @can('users.delete')
                    <form action="{{ route('users.destroy', $u) }}"
                          method="POST"
                          onsubmit="return confirm('¿Eliminar usuario?')"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-sm btn-outline-danger me-2 mb-2 ms-auto">
                            <i class="fas fa-trash"></i>
                            Eliminar
                        </button>
                    </form>
                @endcan

            </div>

        </div>
    </div>
@endforeach
</div>

@section('js')
@parent
@endsection
