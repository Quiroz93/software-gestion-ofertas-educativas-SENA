@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">
        <i class="fas fa-user-shield text-primary"></i>
        Roles del sistema
    </h1>
    <div class="d-flex justify-content-end ">
        @can('roles.create')
        <a href="{{ route('roles.create') }}" class="btn btn-outline-success">
            <i class="fas fa-plus-circle"></i>
            Crear rol
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

@if($roles->isEmpty())
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen roles registrados.
</div>
@endif

<div class="row">
    @foreach($roles as $role)
    <div class="col-md-6 col-lg-4">
        <div class="card card-outline card-primary shadow-sm h-100">

            {{-- HEADER --}}
            <div class="card-header">
                <h3 class="card-title text-uppercase fw-bold">
                    {{ $role->name }}
                </h3>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <p class="mb-2">
                    <strong>Guard:</strong>
                    <span class="badge badge-secondary">
                        {{ $role->guard_name }}
                    </span>
                </p>

                <p class="mb-0">
                    <strong>Permisos:</strong>
                    <span class="badge badge-info">
                        {{ $role->permissions->count() }}
                    </span>
                </p>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">
                <div class="">
                    @can('roles.edit')
                    <a href="{{ route('roles.edit', $role->id) }}"
                        class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                        Editar
                    </a>
                </div>
                @endcan

                @can('roles.delete')
                <form action="{{ route('roles.destroy', $role->id) }}"
                    method="POST"
                    onsubmit="return confirmarEliminacion(event)">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-sm btn-outline-danger">
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

@endsection