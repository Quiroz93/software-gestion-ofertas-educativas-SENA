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
        <a href="{{ route('users.create') }}" class="btn btn-outline-success">
            <i class="fas fa-user-plus"></i>
            Crear usuario
        </a>
        @endcan

        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
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

            {{-- FOOTER --}}
            <div class="card-footer d-flex flex-wrap gap-1">
                <div class="">
                    @can('users.view')
                    <a href="{{ route('users.show', $u) }}"
                        class="btn btn-sm btn-outline-info me-2 mt-2 ms-auto">
                        <i class="fas fa-eye"></i>
                        Ver
                    </a>
                </div>
                @endcan
                <div class="">
                    @can('users.edit')
                    <a href="{{ route('users.edit', $u) }}"
                        class="btn btn-sm btn-outline-warning me-2 mt-2 ms-auto">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
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
                        class="btn btn-sm btn-outline-danger me-2 mt-2 ms-auto">
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

<div class="mt-3">
    <small class="text-muted">
        Total de usuarios:
        <strong>{{ $users->count() }}</strong>
    </small>
</div>

@endif
@endsection