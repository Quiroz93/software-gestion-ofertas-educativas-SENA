@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1 class="m-0">Permisos</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            @can('create_permissions')
                <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Nuevo Permiso
                </a>
            @endcan
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <table id="permissionsTable" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Nombre del Permiso</th>
                    <th>Guard</th>
                    <th style="width: 160px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            @can('edit_permissions')
                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan

                            @can('delete_permissions')
                                <form action="{{ route('permissions.destroy', $permission->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="confirmarEliminacion(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
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

@stop
