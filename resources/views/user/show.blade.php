@extends('layouts.app')

@section('title', 'Ver Usuario')

@section('content_header')
<h1 class="m-0">Detalle de Usuario</h1>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $user->id }}</dd>

                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>

                        <dt class="col-sm-4">Correo</dt>
                        <dd class="col-sm-8"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd>

                        <dt class="col-sm-4">Roles</dt>
                        <dd class="col-sm-8">
                            @foreach($user->roles as $role)
                            <span class="badge badge-info">{{ $role->name }}</span>
                            @endforeach
                        </dd>

                        <dt class="col-sm-4">Permisos</dt>
                        <dd class="col-sm-8">
                            @foreach($user->getDirectPermissions() as $perm)
                            <span class="badge badge-secondary">{{ $perm->name }}</span>
                            @endforeach
                        </dd>
                    </dl>
                </div>

                <div class="card-footer">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
                    @can('users.edit')
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm float-right">Editar</a>
                    @endcan
                    @can('users.roles.edit')
                    <a href="{{ route('users.roles.edit', $user->id) }}"
                        class="btn btn-sm btn-info">
                        Roles
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection