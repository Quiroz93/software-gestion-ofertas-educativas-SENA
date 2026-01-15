@extends('layouts.app')

@section('title', 'Editar Rol')

@section('content_header')
<h1 class="m-0">Editar Rol</h1>
@stop

@section('content')

<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Permisos del rol</h3>
    </div>

    <div class="card-body">

        @foreach($permissions as $category => $items)
            <div class="mb-3 border rounded p-3">

                {{-- Header de categoría --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong class="text-uppercase">{{ $category }}</strong>

                    {{-- Check rápido por categoría --}}
                    <div class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input check-category"
                            data-category="{{ $category }}"
                            id="check_{{ $category }}"
                        >
                        <label class="form-check-label" for="check_{{ $category }}">
                            Seleccionar todo
                        </label>
                    </div>
                </div>

                <div class="row">
                    @foreach($items as $permission)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    id="perm_{{ $permission->id }}"
                                    class="form-check-input permission-checkbox cat-{{ $category }}"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="perm_{{ $permission->id }}">
                                    {{ explode('.', $permission->name)[1] }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

    </div>

@endpush

</div>


@stop

    @push('scripts')
<script>
    document.querySelectorAll('.check-category').forEach(check => {
        check.addEventListener('change', function () {
            const category = this.dataset.category;
            document.querySelectorAll('.cat-' + category)
                .forEach(cb => cb.checked = this.checked);
        });
    });
</script>
@endpush
