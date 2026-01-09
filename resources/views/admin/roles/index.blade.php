@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1 class="m-0">Roles</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            @can('create_roles')
                <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Nuevo Rol
                </a>
            @endcan
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card-body">
        <table id="rolesTable" class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Nombre del Rol</th>
                    <th>Guard</th>
                    <th style="width: 160px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->guard_name }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}"
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            @can('delete_roles')
                                <form action="{{ route('roles.destroy', $role->id) }}"
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
