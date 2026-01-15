@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content_header')
<h1 class="m-0">
    Editar Rol
    <small class="text-muted">— {{ $role->name }}</small>
</h1>
@stop

@section('content')

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    {{-- ================= INFO DEL ROL ================= --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Información del rol</h3>

            {{-- Badge del rol --}}
            <span class="badge bg-info text-dark">
                {{ $role->name }}
            </span>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="role_name">Nombre del rol</label>
                <input
                    id="role_name"
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $role->name) }}"
                    required>

                @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- ================= PERMISOS ================= --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Permisos del rol</h3>
        </div>

        <div class="card-body">

            @foreach($permissions as $category => $items)
            <div class="mb-3 border rounded p-3">

                {{-- Header de categoría --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong class="text-uppercase">{{ $category }}</strong>

                    {{-- Seleccionar todo --}}
                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input permission-checkbox"
                            data-category="{{ $category }}"

                            id="check_{{ $category }}">
                        <label class="form-check-label" for="check_{{ $category }}">
                            Seleccionar todo
                        </label>
                    </div>
                </div>

                <div class="row">
                    @foreach($items as $permission)
                    @php
                    $parts = explode('.', $permission->name);
                    $label = $parts[1] ?? $permission->name;
                    @endphp

                    <div class="col-md-4">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                id="perm_{{ $permission->id }}"
                                class="form-check-input permission-checkbox cat-{{ $category }}"
                                {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ ucfirst(str_replace('_', ' ', $label)) }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            @endforeach

        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </div>

</form>

{{-- ================= CONFIRMACIÓN VISUAL ================= --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@endsection


<script>
    document.querySelectorAll('.check-category').forEach(masterCheck => {
        masterCheck.addEventListener('change', function () {
            const category = this.dataset.category;

            document.querySelectorAll(
                '.permission-checkbox[data-category="' + category + '"]'
            ).forEach(cb => {
                cb.checked = this.checked;
            });
        });
    });
</script>

