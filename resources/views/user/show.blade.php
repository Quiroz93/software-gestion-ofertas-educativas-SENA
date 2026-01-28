@extends('layouts.admin')

@section('title', 'Detalle de Usuario')

@section('content_header')
<h1 class="m-0">
    Detalle de Usuario
    <small class="text-muted">— {{ $user->name }}</small>
</h1>
@stop

@section('content')

@can('users.view')

<div class="container-fluid">

    {{-- ================= INFO DEL USUARIO ================= --}}
    <div class="card card-primary mb-4">
        <div class="card-header">
            <h3 class="card-title">Información del usuario</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                </div>

                <div class="col-md-6">
                    <p>
                        <strong>Estado:</strong>
                        @if ($user->email_verified_at)
                        <span class="badge badge-success">Verificado</span>
                        @else
                        <span class="badge badge-warning">No verificado</span>
                        @endif
                    </p>

                    <p>
                        <strong>Registrado:</strong>
                        {{ $user->created_at->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= ROLES ASIGNADOS ================= --}}
    <div class="card card-info mb-4">
        <div class="card-header">
            <h3 class="card-title">Roles asignados</h3>
        </div>

        <div class="card-body">
            @forelse ($user->roles as $role)
            <span class="badge badge-primary mr-2 mb-2">
                {{ $role->name }}
            </span>
            @empty
            <span class="text-muted">
                Este usuario no tiene roles asignados.
            </span>
            @endforelse
        </div>
    </div>

    {{-- ================= PERMISOS POR ROL ================= --}}
    <div class="card card-secondary mb-4">
        <div class="card-header">
            <h3 class="card-title">Permisos por rol</h3>
        </div>

        <div class="card-body">
            @forelse ($user->roles as $role)
            <div class="mb-4">

                <h5 class="text-primary font-weight-bold mb-2">
                    <i class="fas fa-user-tag mr-1"></i>
                    {{ $role->name }}
                </h5>

                @if ($role->permissions->isNotEmpty())
                <div class="row">
                    @foreach ($role->permissions->groupBy(fn($p) => explode('.', $p->name)[0]) as $category => $permissions)
                    <div class="col-md-4">
                        <div class="card card-outline card-light mb-3">
                            <div class="card-header">
                                <strong>{{ ucfirst($category) }}</strong>
                            </div>

                            <ul class="list-group list-group-flush">
                                @foreach ($permissions as $permission)
                                <li class="list-group-item">
                                    <i class="fas fa-check text-success mr-1"></i>
                                    {{ $permission->name }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <span class="text-muted">
                    Este rol no tiene permisos asignados.
                </span>
                @endif

            </div>
            @empty
            <span class="text-muted">
                No hay roles para mostrar permisos.
            </span>
            @endforelse
        </div>
    </div>

    {{-- ================= PERMISOS DIRECTOS ================= --}}
    <div class="card card-warning mb-4">
        <div class="card-header">
            <h3 class="card-title">Permisos directos del usuario</h3>
        </div>

        <div class="card-body">
            @if ($user->permissions->isNotEmpty())
            <div class="row">
                @foreach ($user->permissions->groupBy(fn($p) => explode('.', $p->name)[0]) as $category => $permissions)
                <div class="col-md-4">
                    <div class="card card-outline card-warning mb-3">
                        <div class="card-header">
                            <strong>{{ ucfirst($category) }}</strong>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach ($permissions as $permission)
                            <li class="list-group-item">
                                <i class="fas fa-user-shield mr-1"></i>
                                {{ $permission->name }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <span class="text-muted">
                Este usuario no tiene permisos directos asignados.
            </span>
            @endif
        </div>
    </div>

    {{-- ================= PERMISOS EFECTIVOS ================= --}}
    <div class="card card-dark mb-4">
        <div class="card-header">
            <h3 class="card-title">Permisos efectivos</h3>
        </div>

        <div class="card-body">
            <div class="d-flex flex-wrap">
                @foreach ($user->getAllPermissions() as $permission)
                <span class="badge badge-secondary mr-2 mb-2">
                    {{ $permission->name }}
                </span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= ACCIONES ================= --}}

    <div class="d-flex justify-content-end gap-2">

        @can('users.edit')
        <a href="{{ route('users.roles.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit mr-1"></i>
            Editar
        </a>
        @endcan

        @can('users.assign.roles')
        <a href="{{ route('users.roles.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-user-tag mr-1"></i>
            Editar roles y permisos
        </a>

        @endcan

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Volver
        </a>
    </div>


</div>

@else
<div class="alert alert-danger">
    No tienes permisos para ver esta información.
</div>
@endcan

@stop
