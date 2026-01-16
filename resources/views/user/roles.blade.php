@extends('layouts.app')

@section('title', 'Editar Roles y Permisos')

@section('content_header')
<h1 class="m-0">
    Editar Roles y Permisos
    <small class="text-muted">— {{ $user->name }}</small>
</h1>
@stop

@section('content')

@can('users.edit')

<div class="row justify-content-center">
    <div class="col-md-10">

        <form method="POST"
              action="{{ route('users.roles.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- ================= ROLES ================= --}}
            <div class="card card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">Roles del usuario</h3>
                </div>

                <div class="card-body">
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->name }}"
                                id="role_{{ $role->id }}"
                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                            >
                            <label class="form-check-label" for="role_{{ $role->id }}">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= PERMISOS DIRECTOS ================= --}}
            <div class="card card-warning mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Permisos directos</h3>

                    <button type="button"
                            class="btn btn-sm btn-outline-dark"
                            id="checkAllPermissions">
                        Seleccionar todo
                    </button>
                </div>

                <div class="card-body">

                    @foreach ($permissions as $category => $perms)
                        <div class="mb-3">
                            <h6 class="font-weight-bold text-primary">
                                {{ ucfirst($category) }}
                            </h6>

                            <div class="row">
                                @foreach ($perms as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input permission-checkbox"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->id }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label"
                                                   for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- ================= ACCIONES ================= --}}
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    Guardar cambios
                </button>

                <a href="{{ route('users.show', $user->id) }}"
                   class="btn btn-secondary">
                    Cancelar
                </a>
            </div>

        </form>

    </div>
</div>

@else
    <div class="alert alert-danger">
        No tienes permisos para realizar esta acción.
    </div>
@endcan

<script>
document.getElementById('checkAllPermissions')
    ?.addEventListener('click', function () {

        const checkboxes = document.querySelectorAll('.permission-checkbox');
        const allChecked = [...checkboxes].every(cb => cb.checked);

        checkboxes.forEach(cb => cb.checked = !allChecked);
    });
</script>

@stop
