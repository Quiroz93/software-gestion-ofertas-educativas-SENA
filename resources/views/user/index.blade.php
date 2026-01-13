@extends('layouts.app')

@section('title', 'Usuarios')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Usuarios</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Usuarios</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                @can('usuarios.create')
                <a href="{{ route('users.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Crear Usuario
                </a>
                @endcan
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
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
                                        @can('usuarios.edit')
                                        <a href="{{ route('users.edit', $u) }}" class="btn btn-warning ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px me-2 ms-2">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        @endcan
                                        @can('usuarios.delete')
                                        <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger ms-2 me-2 btn-sm mt-2 mb-2 min-width-100px">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                        @can('usuarios.view')
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
                    @else
                    <div class="alert alert-info">No hay usuarios registrados.</div>
                    @endif
                </div>

                @if($users->count() > 0)
                <div class="card-footer">
                    <small class="text-muted">Total: <strong>{{ $users->count() }}</strong></small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // placeholder for page JS
</script>
@endsection