@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content_header')
<h1 class="m-0">Editar Rol</h1>
@stop

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Actualizar Rol</h3>
            </div>

            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- Nombre del rol --}}
                    <div class="form-group">
                        <label for="name">Nombre del Rol</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $role->name) }}"
                            required
                            autofocus
                        >
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Guard --}}
                    <div class="form-group">
                        <label for="guard_name">Guard</label>
                        <input
                            type="text"
                            name="guard_name"
                            id="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            value="{{ old('guard_name', $role->guard_name) }}"
                            required
                        >
                        @error('guard_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Permisos --}}
                    <div class="form-group mt-4">
                        <label class="font-weight-bold">
                            Permisos asignados al rol
                        </label>

                        {{-- Check seleccionar todos --}}
                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="checkAllPermissions"
                                {{ count($rolePermissions) === $permissions->count() ? 'checked' : '' }}
                            >
                            <label class="form-check-label font-weight-bold" for="checkAllPermissions">
                                Seleccionar todos los permisos
                            </label>
                        </div>

                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input permission-checkbox"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            id="permission_{{ $permission->id }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                        >
                                        <label
                                            class="form-check-label"
                                            for="permission_{{ $permission->id }}"
                                        >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Rol
                    </button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@stop

@section('js')
<script>
    document.getElementById('checkAllPermissions')
        .addEventListener('change', function () {

            const isChecked = this.checked;

            document.querySelectorAll('.permission-checkbox')
                .forEach(function (checkbox) {
                    checkbox.checked = isChecked;
                });
        });
</script>
@endsection
