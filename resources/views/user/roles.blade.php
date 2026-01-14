@extends('layouts.app')

@section('title', 'Asignar Roles')

@section('content_header')
<h1 class="m-0">Asignar Roles a Usuario</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Usuario: {{ $user->name }}</h3>
            </div>

            <form method="POST" action="{{ route('users.roles.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">

                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->name }}"
                                id="role_{{ $role->id }}"
                                {{ in_array($role->name, $userRoles) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        Guardar Roles
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@stop
