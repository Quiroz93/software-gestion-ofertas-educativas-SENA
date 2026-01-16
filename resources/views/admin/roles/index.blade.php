@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
<h1 class="m-0">Roles</h1>

{{-- ================= CONFIRMACIÓN VISUAL ================= --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@stop

@section('content')

@if($roles->isEmpty())
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    No existen roles registrados.
</div>
@endif

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            @can('roles.create')
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Crear Nuevo Rol
            </a>
            @endcan
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
        </div>
    </div>

    <div class="card-body">
        <table id="rolesTable" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Nombre del Rol</th>
                    <th>Guard</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}"
                            class="btn btn-warning ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px me-2 ms-2">
                            <i class="fas fa-edit"></i>Editar
                        </a>

                        @can('roles.delete')
                        <form action="{{ route('roles.destroy', $role->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="confirmarEliminacion(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px">
                                <i class="fas fa-trash"></i>Eliminar
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">

                @can('roles.edit')
                <div class="d-flex flex-column">
                    <a href="{{ route('roles.edit', $role->id) }}"
                        class="btn btn-outline-warning btn-sm me-2 mb-2">
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

                    <button type="submit" class="btn btn-outline-danger btn-sm">
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

@stop
